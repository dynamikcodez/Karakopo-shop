@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    <!-- Quick Actions Banner -->
    <div class="bg-gradient-to-r from-[#5B1032] to-[#7a1543] rounded-2xl p-6 text-white shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-black">Welcome back, {{ auth()->user()->name ?? 'Administrator' }}!</h2>
            <p class="text-xs sm:text-sm text-white/80 mt-1">Manage products, monitor sales, and generate promo captions for marketing.</p>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-maroon text-xs sm:text-sm font-bold rounded-xl hover:bg-gray-100 shadow transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New Product
            </a>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-bold rounded-xl shadow transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                View Orders
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 border-l-4 border-l-[#5B1032]">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Sales</h3>
            <p class="text-xl sm:text-2xl font-black text-gray-900 mt-1">₦{{ number_format($stats['total_sales']) }}</p>
            <span class="text-[11px] text-green-600 font-semibold">Verified revenue</span>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 border-l-4 border-l-blue-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Orders</h3>
            <p class="text-xl sm:text-2xl font-black text-gray-900 mt-1">{{ $stats['orders_count'] }}</p>
            <span class="text-[11px] text-blue-600 font-semibold">Lifetime orders →</span>
        </a>

        <a href="{{ route('admin.orders.index', ['order_status' => 'Pending']) }}" class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 border-l-4 border-l-yellow-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Pending Orders</h3>
            <p class="text-xl sm:text-2xl font-black text-gray-900 mt-1">{{ $stats['pending_orders'] }}</p>
            <span class="text-[11px] text-yellow-600 font-semibold">Needs attention →</span>
        </a>

        <a href="{{ route('admin.orders.index', ['order_status' => 'Delivered']) }}" class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 border-l-4 border-l-green-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Delivered</h3>
            <p class="text-xl sm:text-2xl font-black text-gray-900 mt-1">{{ $stats['completed_orders'] }}</p>
            <span class="text-[11px] text-green-600 font-semibold">Completed →</span>
        </a>

        <a href="{{ route('admin.products.index') }}" class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 border-l-4 border-l-purple-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Catalog</h3>
            <p class="text-xl sm:text-2xl font-black text-gray-900 mt-1">{{ $stats['product_count'] }}</p>
            <span class="text-[11px] text-purple-600 font-semibold">Live products →</span>
        </a>

        <a href="{{ route('admin.products.index') }}" class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 border-l-4 border-l-red-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Low Stock</h3>
            <p class="text-xl sm:text-2xl font-black text-gray-900 mt-1">{{ $stats['low_stock'] }}</p>
            <span class="text-[11px] text-red-600 font-semibold">≤ 5 units remaining →</span>
        </a>
    </div>

    <!-- Recent Orders Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900">Recent Customer Orders</h3>
                <p class="text-xs text-gray-500">Latest checkout activities across your shop</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-maroon hover:underline">
                View All Orders &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4 sm:px-6">Order #</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Items</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Payment</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 sm:px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-4 sm:px-6 font-bold text-maroon whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:underline">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-gray-900 text-sm">{{ $order->customer_name }}</div>
                                <div class="text-xs text-gray-400">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-gray-600 whitespace-nowrap">
                                {{ $order->items->sum('quantity') }} items
                            </td>
                            <td class="py-3.5 px-4 font-bold text-gray-900 whitespace-nowrap">
                                ₦{{ number_format($order->total, 2) }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $order->payment_status === 'Paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-right whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-cream text-maroon hover:bg-maroon hover:text-white transition-colors">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400 text-sm">
                                No orders received yet. Once customers checkout, orders will appear here!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
