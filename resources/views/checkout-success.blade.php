@extends('layouts.app')

@section('title', 'Order Received #' . $order->order_number . ' | Karakopo')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
    <!-- Success Banner -->
    <div class="text-center">
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 text-green-600 mb-6 shadow-sm">
            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <span class="inline-block bg-cream text-maroon text-xs font-black uppercase tracking-wider px-3 py-1 rounded-full mb-2">Order Confirmed</span>
        <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Order #{{ $order->order_number }}</h1>
        <p class="mt-2 text-sm sm:text-base text-gray-600 max-w-lg mx-auto">
            Thank you, <strong>{{ $order->customer_name }}</strong>! Your order has been recorded. Complete your order via WhatsApp below.
        </p>
    </div>

    <!-- Primary Action: Big WhatsApp Confirmation CTA -->
    <div class="mt-8 bg-gradient-to-br from-green-600 to-[#20ba59] text-white rounded-3xl p-6 sm:p-8 shadow-xl text-center">
        <div class="flex items-center justify-center space-x-2 mb-2">
            <span class="text-2xl">💬</span>
            <h2 class="text-xl sm:text-2xl font-black">Confirm on WhatsApp</h2>
        </div>
        <p class="text-xs sm:text-sm text-green-100 max-w-md mx-auto mb-6">
            Click the button below to send your structured order details and receipt directly to our WhatsApp support team for instant dispatch.
        </p>
        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-white text-green-700 hover:bg-gray-100 rounded-2xl font-black text-base sm:text-lg shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-0.5">
            <svg class="w-6 h-6 mr-2 fill-current text-green-600" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
            <span>Open WhatsApp to Confirm (₦{{ number_format($order->total, 2) }})</span>
        </a>
    </div>

    <!-- Bank Transfer Details Card -->
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
            <h3 class="text-base font-bold text-gray-900 flex items-center">
                <span class="text-lg mr-2">🏦</span>
                Direct Bank Transfer Details
            </h3>
            <span class="text-xs bg-amber-50 text-amber-700 font-bold px-2 py-1 rounded-full">
                Online Card Payment Coming Soon
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm bg-gray-50 p-4 rounded-xl mb-4">
            <div>
                <span class="block text-xs text-gray-500 font-medium">Bank Name</span>
                <span class="font-bold text-gray-900">{{ $bank['name'] ?? 'OPay' }}</span>
            </div>
            <div>
                <span class="block text-xs text-gray-500 font-medium">Account Number</span>
                <div class="flex items-center space-x-2 mt-0.5">
                    <span class="font-mono font-bold text-gray-900 select-all">{{ $bank['account_number'] ?? '8135631609' }}</span>
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $bank['account_number'] ?? '8135631609' }}'); window.showToast('Account number copied!');" class="text-xs text-maroon hover:underline font-semibold" title="Copy">
                        Copy
                    </button>
                </div>
            </div>
            <div>
                <span class="block text-xs text-gray-500 font-medium">Account Name</span>
                <span class="font-bold text-gray-900">{{ $bank['account_name'] ?? 'Karakopo Retail' }}</span>
            </div>

        </div>

        <p class="text-xs text-gray-500 italic">
            * Please include your Order Number (<strong>{{ $order->order_number }}</strong>) as the transfer description/narration.
        </p>
    </div>

    <!-- Order Items Breakdown -->
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">
            Items Ordered
        </h3>

        <ul class="divide-y divide-gray-100 mb-6">
            @foreach($order->items as $item)
                <li class="py-3 flex justify-between items-center text-sm">
                    <div class="pr-4">
                        <span class="font-semibold text-gray-900">{{ $item->name }}</span>
                        <span class="text-xs text-gray-500 block">Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 2) }}</span>
                    </div>
                    <span class="font-bold text-gray-900">₦{{ number_format($item->total, 2) }}</span>
                </li>
            @endforeach
        </ul>

        <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
            <div class="flex justify-between text-gray-600">
                <span>Subtotal</span>
                <span>₦{{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Delivery to {{ $order->city }}, {{ $order->state }}</span>
                <span>₦{{ number_format($order->delivery_fee, 2) }}</span>
            </div>
            <div class="border-t border-gray-200 pt-3 flex justify-between text-base font-black text-gray-900">
                <span>Total</span>
                <span class="text-maroon text-lg">₦{{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Navigation Back -->
    <div class="mt-8 text-center">
        <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-maroon text-white font-bold text-sm shadow hover-bg-maroon transition-colors">
            Continue Shopping &rarr;
        </a>
    </div>
</div>
@endsection
