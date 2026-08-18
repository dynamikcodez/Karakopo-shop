<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $deliveryFee = $subtotal > 0 ? 3000 : 0; // Flat delivery fee for MVP
        $total = $subtotal + $deliveryFee;

        return view('cart', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::with('primaryImage')->findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = session()->get('cart', []);

        $price = $product->sale_price && $product->sale_price < $product->price 
                    ? $product->sale_price 
                    : $product->price;

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $request->quantity,
                'price' => $price,
                'image' => $product->primaryImage ? $product->primaryImage->image_path : null
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $cart = session()->get('cart');

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}
