<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\Payment\PaymentGatewayInterface;

class CheckoutController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $deliveryFee = 3000;
        $total = $subtotal + $deliveryFee;

        $bank = config('services.bank');
        $whatsappNumber = config('services.whatsapp.number');

        return view('checkout', compact('cart', 'subtotal', 'deliveryFee', 'total', 'bank', 'whatsappNumber'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'delivery_instructions' => 'nullable|string',
            'payment_method' => 'nullable|string|in:whatsapp,online',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $deliveryFee = 3000;
        $total = $subtotal + $deliveryFee;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'delivery_address' => $validated['delivery_address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'delivery_instructions' => $validated['delivery_instructions'] ?? null,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'payment_status' => 'Pending',
                'order_status' => 'Pending',
            ]);

            foreach ($cart as $productId => $item) {
                $product = Product::lockForUpdate()->findOrFail($productId);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Product {$product->name} does not have enough stock.");
                }

                $order->items()->create([
                    'product_id' => $productId,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Clear shopping cart after creating the order
            session()->forget('cart');

            // Default & primary flow: WhatsApp payment & order confirmation
            return redirect()->route('checkout.success', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage())->withInput();
        }
    }

    public function verify(Request $request)
    {
        $reference = $request->query('reference') ?? $request->query('trxref');
        
        if (!$reference) {
            return redirect()->route('home')->with('error', 'No payment reference found.');
        }

        $order = Order::where('order_number', $reference)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        if ($order->payment_status === 'Paid') {
            return redirect()->route('checkout.success', $order->order_number);
        }

        try {
            $isSuccessful = $this->paymentGateway->verify($reference);

            if ($isSuccessful) {
                DB::transaction(function () use ($order, $reference) {
                    $order->update([
                        'payment_status' => 'Paid',
                        'order_status' => 'Processing'
                    ]);

                    Payment::create([
                        'order_id' => $order->id,
                        'reference' => $reference,
                        'provider' => 'paystack',
                        'amount' => $order->total,
                        'status' => 'Success'
                    ]);

                    foreach ($order->items as $item) {
                        if ($item->product_id) {
                            Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
                        }
                    }
                });

                session()->forget('cart');
                return redirect()->route('checkout.success', $order->order_number);
            }

            $order->update(['payment_status' => 'Failed']);
            return redirect()->route('cart.index')->with('error', 'Payment verification failed.');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }

    public function success($order_number)
    {
        $order = Order::with(['items.product'])->where('order_number', $order_number)->firstOrFail();
        
        $whatsappNumber = preg_replace('/[^0-9]/', '', config('services.whatsapp.number', '2348126215642'));
        $bank = config('services.bank');

        // Build structured WhatsApp order message
        $whatsappMessage = "Hello Karakopo! 🛍️\n"
                         . "I just placed an order on the website:\n\n"
                         . "📋 *Order Number:* " . $order->order_number . "\n"
                         . "👤 *Customer Name:* " . $order->customer_name . "\n"
                         . "📞 *Phone:* " . $order->customer_phone . "\n"
                         . "📍 *Delivery Address:* " . $order->delivery_address . ", " . $order->city . ", " . $order->state . "\n\n"
                         . "🛒 *Items Ordered:*\n";

        foreach ($order->items as $item) {
            $whatsappMessage .= "• " . $item->name . " (x" . $item->quantity . ") - ₦" . number_format($item->total, 2) . "\n";
        }

        $whatsappMessage .= "\n💵 *Subtotal:* ₦" . number_format($order->subtotal, 2) . "\n"
                         . "🚚 *Delivery Fee:* ₦" . number_format($order->delivery_fee, 2) . "\n"
                         . "💰 *Total Amount:* ₦" . number_format($order->total, 2) . "\n";

        if ($order->delivery_instructions) {
            $whatsappMessage .= "📝 *Delivery Note:* " . $order->delivery_instructions . "\n";
        }

        $whatsappMessage .= "\nPlease confirm availability and let me know payment transfer instructions. Thank you!";

        $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($whatsappMessage);

        return view('checkout-success', compact('order', 'whatsappUrl', 'whatsappMessage', 'bank', 'whatsappNumber'));
    }
}
