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

    // Injecting the interface so we can swap it out later if needed
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

        return view('checkout', compact('cart', 'subtotal', 'deliveryFee', 'total'));
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
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $deliveryFee = 3000;
        $total = $subtotal + $deliveryFee;

        DB::beginTransaction();

        try {
            $order = Order::create(array_merge($validated, [
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'payment_status' => 'Pending',
                'order_status' => 'Pending',
            ]));

            foreach ($cart as $productId => $item) {
                // Ensure stock is available
                $product = Product::lockForUpdate()->findOrFail($productId);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Product {$product->name} is out of stock.");
                }

                $order->items()->create([
                    'product_id' => $productId,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }

            // Note: We don't reduce inventory here. We reduce it AFTER successful payment verification.

            DB::commit();

            // Initialize payment
            $paymentUrl = $this->paymentGateway->initialize($order);

            return redirect()->away($paymentUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
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

                    // Reduce stock
                    foreach ($order->items as $item) {
                        if ($item->product_id) {
                            Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
                        }
                    }
                });

                // Clear cart
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
        $order = Order::with('items')->where('order_number', $order_number)->firstOrFail();
        
        if ($order->payment_status !== 'Paid') {
            return redirect()->route('home');
        }

        return view('checkout-success', compact('order'));
    }
}
