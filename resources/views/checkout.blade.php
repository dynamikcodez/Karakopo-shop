@extends('layouts.app')

@section('title', 'Checkout | Karakopo')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-8">Checkout</h1>
        
        <form action="{{ route('checkout.store') }}" method="POST" class="lg:grid lg:grid-cols-12 lg:gap-x-12">
            @csrf
            <!-- Left Column: Delivery Details -->
            <div class="lg:col-span-7">
                <div class="bg-white shadow rounded-lg px-4 py-6 sm:p-6 mb-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Delivery Information</h2>
                    
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div class="sm:col-span-2">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ auth()->check() ? auth()->user()->name : '' }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-maroon focus:border-maroon sm:text-sm p-2" required>
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="customer_email" id="customer_email" value="{{ auth()->check() ? auth()->user()->email : '' }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-maroon focus:border-maroon sm:text-sm p-2" required>
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="customer_phone" id="customer_phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-maroon focus:border-maroon sm:text-sm p-2" required>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                            <input type="text" name="delivery_address" id="delivery_address" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-maroon focus:border-maroon sm:text-sm p-2" required>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-maroon focus:border-maroon sm:text-sm p-2" required>
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                            <input type="text" name="state" id="state" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-maroon focus:border-maroon sm:text-sm p-2" required>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="delivery_instructions" class="block text-sm font-medium text-gray-700">Delivery Instructions (Optional)</label>
                            <textarea name="delivery_instructions" id="delivery_instructions" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-maroon focus:border-maroon sm:text-sm p-2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-5">
                <div class="bg-white shadow rounded-lg px-4 py-6 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                    
                    <ul role="list" class="divide-y divide-gray-200 mb-6">
                        @foreach($cart as $id => $item)
                            <li class="py-4 flex">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="h-16 w-16 rounded-md object-cover border border-gray-200">
                                @else
                                    <div class="h-16 w-16 rounded-md bg-gray-100 flex items-center justify-center border border-gray-200">
                                        <span class="text-xs text-gray-400">No Img</span>
                                    </div>
                                @endif
                                <div class="ml-4 flex-1 flex flex-col">
                                    <div>
                                        <div class="flex justify-between text-sm font-medium text-gray-900">
                                            <h3>{{ $item['name'] }}</h3>
                                            <p class="ml-4">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex-1 flex items-end justify-between text-sm">
                                        <p class="text-gray-500">Qty {{ $item['quantity'] }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="space-y-4 border-t border-gray-200 pt-6 text-sm font-medium text-gray-900">
                        <div class="flex items-center justify-between">
                            <dt class="text-gray-600">Subtotal</dt>
                            <dd>₦{{ number_format($subtotal, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-gray-600">Delivery Fee</dt>
                            <dd>₦{{ number_format($deliveryFee, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 pt-4 text-base font-bold">
                            <dt>Total to Pay</dt>
                            <dd>₦{{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <button type="submit" class="w-full bg-maroon border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-bold text-white hover:bg-[#7a1543] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-maroon flex justify-center items-center">
                            Pay with Paystack
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
