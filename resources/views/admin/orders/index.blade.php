@extends('admin.layouts.app')

@section('title', 'Customer Orders')

@section('content')
<div class="space-y-6">
    <!-- Header & Search Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order #, customer name, email..." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-xl focus:border-maroon focus:ring-maroon">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="flex flex-wrap sm:flex-nowrap gap-2">
                <select name="order_status" onchange="this.form.submit()" class="text-xs sm:text-sm border border-gray-300 rounded-xl py-2 px-3 bg-white focus:border-maroon focus:ring-maroon">
                    <option value="">All Order Statuses</option>
                    <option value="Pending" {{ request('order_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ request('order_status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Shipped" {{ request('order_status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="Delivered" {{ request('order_status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Cancelled" {{ request('order_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <select name="payment_status" onchange="this.form.submit()" class="text-xs sm:text-sm border border-gray-300 rounded-xl py-2 px-3 bg-white focus:border-maroon focus:ring-maroon">
                    <option value="">All Payments</option>
                    <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Pending" {{ request('payment_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Failed" {{ request('payment_status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-maroon text-white text-xs sm:text-sm font-bold rounded-xl hover-bg-maroon transition-colors shadow">
                    Filter
                </button>

                @if(request('search') || request('order_status') || request('payment_status'))
                    <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 text-xs sm:text-sm text-gray-500 hover:text-maroon flex items-center">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                <thead class="bg-gray-50 text-gray-600 font-semibold text-xs uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="py-3.5 px-4 sm:px-6">Order #</th>
                        <th scope="col" class="py-3.5 px-4">Customer</th>
                        <th scope="col" class="py-3.5 px-4">Items</th>
                        <th scope="col" class="py-3.5 px-4">Total</th>
                        <th scope="col" class="py-3.5 px-4">Payment</th>
                        <th scope="col" class="py-3.5 px-4">Status</th>
                        <th scope="col" class="py-3.5 px-4">Date</th>
                        <th scope="col" class="py-3.5 px-4 sm:px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4 sm:px-6 font-bold text-maroon whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:underline">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-medium text-gray-900">{{ $order->customer_name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->customer_email }}</div>
                                <div class="text-xs text-gray-400">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="py-4 px-4 text-gray-600 whitespace-nowrap">
                                {{ $order->items->sum('quantity') }} items
                            </td>
                            <td class="py-4 px-4 font-bold text-gray-900 whitespace-nowrap">
                                ₦{{ number_format($order->total, 2) }}
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($order->payment_status === 'Paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        ● Paid
                                    </span>
                                @elseif($order->payment_status === 'Failed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        ● Failed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        ● Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Processing' => 'bg-blue-100 text-blue-800',
                                        'Shipped' => 'bg-purple-100 text-purple-800',
                                        'Delivered' => 'bg-green-100 text-green-800',
                                        'Cancelled' => 'bg-gray-100 text-gray-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses[$order->order_status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs text-gray-500 whitespace-nowrap">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-right whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-cream text-maroon hover:bg-maroon hover:text-white transition-colors">
                                    Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                No orders found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
