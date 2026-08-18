@extends('layouts.app')

@section('title', 'Order Confirmed | Karakopo')

@section('content')
<div class="bg-white py-16 sm:py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-8">
            <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl mb-4">Payment Successful!</h1>
        <p class="text-lg text-gray-500 mb-8">Thank you for your order, {{ explode(' ', $order->customer_name)[0] }}. Your order <span class="font-bold text-maroon">{{ $order->order_number }}</span> is currently being processed.</p>
        
        <div class="bg-gray-50 rounded-lg p-6 text-left border border-gray-200 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Order Summary</h3>
            <ul class="divide-y divide-gray-200 mb-4">
                @foreach($order->items as $item)
                    <li class="py-3 flex justify-between">
                        <span class="text-gray-600">{{ $item->name }} (x{{ $item->quantity }})</span>
                        <span class="font-medium">₦{{ number_format($item->total, 2) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="flex justify-between pt-3 border-t font-bold text-gray-900">
                <span>Total Paid</span>
                <span>₦{{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <p class="text-gray-500 mb-8">A receipt has been sent to {{ $order->customer_email }}. We will notify you when your items are on the way to {{ $order->city }}, {{ $order->state }}.</p>
        
        <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-maroon hover-bg-maroon">
            Continue Shopping
        </a>
    </div>
</div>
@endsection
