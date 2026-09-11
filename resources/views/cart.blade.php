@extends('layouts.app')

@section('title', 'Your Cart | Karakopo')

@section('content')
<div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Shopping Cart</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
    @if(count($cart) > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <!-- Items List -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
                    @foreach($cart as $id => $details)
                        <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <!-- Image and Title -->
                            <div class="flex items-center space-x-4 w-full sm:w-auto">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-gray-50 flex-shrink-0 overflow-hidden border border-gray-200">
                                    <img src="{{ karakopo_image_url($details['image'] ?? null) }}" 
                                         onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" 
                                         class="w-full h-full object-cover" 
                                         alt="{{ $details['name'] }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2">{{ $details['name'] }}</h3>
                                    <p class="text-sm font-semibold text-gray-700 mt-1">₦{{ number_format($details['price'], 2) }} each</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Item Subtotal: <strong class="text-gray-900">₦{{ number_format($details['price'] * $details['quantity'], 2) }}</strong></p>
                                </div>
                            </div>

                            <!-- Quantity and Action Controls -->
                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto space-x-4 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <label for="quantity-{{ $id }}" class="text-xs font-medium text-gray-500 sm:sr-only">Qty:</label>
                                    <input type="number" id="quantity-{{ $id }}" name="quantity" value="{{ $details['quantity'] }}" min="1" max="99" class="w-16 rounded-lg border border-gray-300 py-1.5 px-2 text-center text-sm font-semibold focus:border-maroon focus:ring-maroon">
                                    <button type="submit" class="px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors">
                                        Update
                                    </button>
                                </form>

                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Remove item">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('shop') }}" class="inline-flex items-center text-sm font-bold text-maroon hover:underline">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="mt-8 lg:mt-0 lg:col-span-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4">Order Summary</h2>

                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex items-center justify-between text-gray-600">
                            <dt>Subtotal</dt>
                            <dd class="font-semibold text-gray-900">₦{{ number_format($subtotal, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <dt>Estimated Delivery</dt>
                            <dd class="font-semibold text-gray-900">₦{{ number_format($deliveryFee, 2) }}</dd>
                        </div>
                        <div class="border-t border-gray-200 pt-4 flex items-center justify-between text-base">
                            <dt class="font-bold text-gray-900">Total</dt>
                            <dd class="font-black text-xl text-maroon">₦{{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <a href="{{ route('checkout.index') }}" class="w-full bg-maroon text-white font-bold py-3.5 px-4 rounded-xl hover-bg-maroon transition-all shadow-md hover:shadow-lg flex items-center justify-center space-x-2">
                            <span>Proceed to Checkout</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                    <p class="text-center text-xs text-gray-400 mt-3 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Secure Nigerian payments powered by Paystack
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100 max-w-xl mx-auto p-8">
            <div class="w-16 h-16 bg-cream text-maroon rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Your cart is empty</h2>
            <p class="text-sm text-gray-500 mt-2 max-w-xs mx-auto">Discover great household items and essentials at everyday low prices.</p>
            <div class="mt-6">
                <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-maroon text-white font-bold text-sm shadow hover-bg-maroon transition-colors">
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
