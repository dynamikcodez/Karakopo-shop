@extends('admin.layouts.app')

@section('title', 'Order Details #' . $order->order_number)

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-bold text-maroon hover:underline">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Orders
        </a>
        <div class="flex items-center space-x-2">
            <span class="text-xs text-gray-500">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main: Order Items & Financials -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">
                    Purchased Items ({{ $order->items->sum('quantity') }})
                </h3>

                <ul class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <li class="py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 rounded-xl bg-gray-50 flex-shrink-0 overflow-hidden border border-gray-200">
                                    @if($item->product && $item->product->primaryImage)
                                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" class="w-full h-full object-cover" alt="{{ $item->name }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">
                                        @if($item->product)
                                            <a href="{{ route('product.show', $item->product->slug) }}" target="_blank" class="hover:text-maroon">
                                                {{ $item->name }} ↗
                                            </a>
                                        @else
                                            {{ $item->name }}
                                        @endif
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-0.5">₦{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-black text-gray-900">₦{{ number_format($item->total, 2) }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Order Totals Breakdown -->
                <div class="border-t border-gray-100 pt-4 mt-2 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Items Subtotal</span>
                        <span>₦{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Delivery Fee</span>
                        <span>₦{{ number_format($order->delivery_fee, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between text-base font-black text-gray-900">
                        <span>Total Paid / Payable</span>
                        <span class="text-maroon text-lg">₦{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">
                    Payment Information
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="block text-xs text-gray-500">Provider</span>
                        <span class="font-semibold text-gray-900 uppercase">{{ $order->payment->provider ?? 'Paystack' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Payment Status</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $order->payment_status === 'Paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Reference</span>
                        <span class="font-mono text-xs text-gray-700 select-all">{{ $order->payment->reference ?? $order->order_number }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Status Update & Customer Information -->
        <div class="space-y-6">
            <!-- Order Management Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">
                    Update Order Status
                </h3>

                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="order_status" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Fulfillment Status</label>
                        <select name="order_status" id="order_status" class="w-full text-sm border border-gray-300 rounded-xl py-2 px-3 focus:border-maroon focus:ring-maroon bg-white">
                            <option value="Pending" {{ $order->order_status === 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="Processing" {{ $order->order_status === 'Processing' ? 'selected' : '' }}>🔄 Processing</option>
                            <option value="Shipped" {{ $order->order_status === 'Shipped' ? 'selected' : '' }}>📦 Shipped / In Transit</option>
                            <option value="Delivered" {{ $order->order_status === 'Delivered' ? 'selected' : '' }}>✅ Delivered</option>
                            <option value="Cancelled" {{ $order->order_status === 'Cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label for="payment_status" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="w-full text-sm border border-gray-300 rounded-xl py-2 px-3 focus:border-maroon focus:ring-maroon bg-white">
                            <option value="Paid" {{ $order->payment_status === 'Paid' ? 'selected' : '' }}>🟢 Paid</option>
                            <option value="Pending" {{ $order->payment_status === 'Pending' ? 'selected' : '' }}>🟡 Pending</option>
                            <option value="Failed" {{ $order->payment_status === 'Failed' ? 'selected' : '' }}>🔴 Failed</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-maroon text-white text-sm font-bold rounded-xl hover-bg-maroon transition-colors shadow">
                        Save Status Changes
                    </button>
                </form>
            </div>

            <!-- Customer Details Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">
                    Customer & Delivery
                </h3>

                <div class="space-y-3 text-sm">
                    <div>
                        <span class="block text-xs text-gray-500">Customer Name</span>
                        <span class="font-bold text-gray-900">{{ $order->customer_name }}</span>
                    </div>

                    <div>
                        <span class="block text-xs text-gray-500">Email Address</span>
                        <a href="mailto:{{ $order->customer_email }}" class="text-maroon hover:underline font-medium break-all">{{ $order->customer_email }}</a>
                    </div>

                    <div>
                        <span class="block text-xs text-gray-500">Phone Number</span>
                        <div class="flex items-center space-x-2 mt-0.5">
                            <a href="tel:{{ $order->customer_phone }}" class="font-bold text-gray-900 hover:underline">{{ $order->customer_phone }}</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank" class="text-xs bg-green-500 text-white px-2 py-0.5 rounded font-semibold hover:bg-green-600 transition-colors">
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <span class="block text-xs text-gray-500">Delivery Address</span>
                        <p class="font-medium text-gray-800 leading-relaxed mt-0.5">
                            {{ $order->delivery_address }}<br>
                            {{ $order->city }}, {{ $order->state }}
                        </p>
                    </div>

                    @if($order->delivery_instructions)
                    <div class="pt-2 border-t border-gray-100">
                        <span class="block text-xs text-gray-500">Delivery Instructions</span>
                        <p class="text-xs bg-gray-50 p-2.5 rounded-lg text-gray-700 mt-1 italic">
                            "{{ $order->delivery_instructions }}"
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
