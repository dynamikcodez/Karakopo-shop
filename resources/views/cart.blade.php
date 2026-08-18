@extends('layouts.app')

@section('title', 'Shopping Cart | Karakopo')

@section('content')
<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900">Your Cart</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(count($cart) > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <div class="lg:col-span-8">
                <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
                    @foreach($cart as $id => $details)
                        <li class="flex py-6 sm:py-10">
                            <div class="flex-shrink-0">
                                @if($details['image'])
                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-24 h-24 rounded-md object-center object-cover sm:w-32 sm:h-32">
                                @else
                                    <div class="w-24 h-24 rounded-md bg-gray-100 flex items-center justify-center sm:w-32 sm:h-32">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                    <div>
                                        <div class="flex justify-between">
                                            <h3 class="text-sm">
                                                <a href="#" class="font-medium text-gray-700 hover:text-gray-800">{{ $details['name'] }}</a>
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-sm font-medium text-gray-900">₦{{ number_format($details['price'], 2) }}</p>
                                    </div>

                                    <div class="mt-4 sm:mt-0 sm:pr-9">
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="product_id" value="{{ $id }}">
                                            <label for="quantity-{{ $id }}" class="sr-only">Quantity, {{ $details['name'] }}</label>
                                            <input type="number" id="quantity-{{ $id }}" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-16 rounded-md border border-gray-300 py-1.5 text-base leading-5 font-medium text-gray-700 text-center shadow-sm focus:outline-none focus:ring-1 focus:ring-maroon focus:border-maroon sm:text-sm">
                                            <button type="submit" class="ml-2 text-sm text-maroon hover:underline">Update</button>
                                        </form>

                                        <div class="absolute top-0 right-0">
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <button type="submit" class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Remove</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                                    <span>Subtotal: <span class="font-medium text-gray-900">₦{{ number_format($details['price'] * $details['quantity'], 2) }}</span></span>
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('shop') }}" class="text-maroon font-medium hover:underline">&larr; Continue Shopping</a>
                </div>
            </div>

            <!-- Order Summary -->
            <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-4">
                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">₦{{ number_format($subtotal, 2) }}</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="flex items-center text-sm text-gray-600">
                            <span>Delivery Fee</span>
                        </dt>
                        <dd class="text-sm font-medium text-gray-900">₦{{ number_format($deliveryFee, 2) }}</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="text-base font-medium text-gray-900">Total</dt>
                        <dd class="text-base font-medium text-gray-900">₦{{ number_format($total, 2) }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="/checkout" class="w-full bg-maroon border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-[#7a1543] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-maroon flex justify-center">
                        Proceed to Checkout
                    </a>
                </div>
            </section>
        </div>
    @else
        <div class="text-center py-20">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h3>
            <p class="mt-1 text-sm text-gray-500">Looks like you haven't added anything to your cart yet.</p>
            <div class="mt-6">
                <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-maroon hover-bg-maroon">
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
