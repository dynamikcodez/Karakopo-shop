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
            <button type="button" onclick="openOnboardingModal()" class="inline-flex items-center px-4 py-2 bg-amber-400 hover:bg-amber-300 text-maroon text-xs sm:text-sm font-extrabold rounded-xl shadow transition-colors">
                <span class="mr-1.5">🎓</span>
                Admin Onboarding Guide
            </button>
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

    <!-- Inventory Sync & Developer Support for Mum -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Informal, Loving Developer Support Card for Mum -->
        <div class="lg:col-span-8 bg-gradient-to-br from-[#520118] via-[#3B0011] to-gray-900 text-white rounded-3xl shadow-xl border border-white/10 p-6 sm:p-8 overflow-hidden relative">
            <div class="relative z-10 space-y-3">
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-brand-amber text-brand-maroon shadow-sm">
                        ❤️ Developer & Tech Support
                    </span>
                    <span class="inline-flex items-center text-xs text-green-300 font-semibold">
                        <span class="w-2 h-2 rounded-full bg-green-400 mr-1.5 animate-pulse"></span>
                        Always on standby for you, Mum!
                    </span>
                </div>
                
                <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                    Hey Mum! Need anything added, changed, or fixed?
                </h3>
                
                <p class="text-xs sm:text-sm text-white/85 leading-relaxed max-w-2xl">
                    Don't worry about any technical stress. If you have new products to upload, want prices changed, need a new promotional banner, or notice anything unusual with customer orders, just reach out to me directly and I'll handle it immediately.
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-white/70 border-t border-white/10">
                    <div>📞 My Direct Phone: <strong class="text-white">+234 703 229 3819</strong></div>
                    <div>🏦 Your Store OPay: <strong class="text-white">8135631609 (Karakopo Retail)</strong></div>
                    <div>💬 Store WhatsApp: <strong class="text-white">+234 812 621 5642</strong></div>
                </div>

                <div class="pt-3 flex flex-wrap items-center gap-2.5">
                    <a href="https://wa.me/2347032293819?text=Hi%20son,%20I%20need%20a%20hand%20with%20the%20Karakopo%20website..." target="_blank" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-green-500 hover:bg-green-600 text-white shadow-lg shadow-green-500/25 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        Chat with Me on WhatsApp
                    </a>
                    <a href="tel:+2347032293819" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-white/15 hover:bg-white/25 text-white border border-white/20 transition-all">
                        <svg class="w-4 h-4 mr-2 text-brand-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Call My Line
                    </a>
                    <button type="button" onclick="navigator.clipboard.writeText('+2347032293819'); window.showToast('My phone number (+2347032293819) copied!');" class="inline-flex items-center justify-center px-3.5 py-2.5 rounded-xl text-xs font-semibold text-white/80 hover:text-white hover:bg-white/10 transition-colors">
                        📋 Copy My Number
                    </button>
                </div>
            </div>
            
            <!-- Soft brand accent circle in background -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-brand-rose/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- Inventory Sync & Data Backup Card -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-brand-creamBorder flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-black uppercase text-brand-maroon tracking-wider mb-2">
                    <span>📦</span>
                    <span>Inventory & Data Sync</span>
                </div>
                <h4 class="font-bold text-gray-900 text-sm">Download Live Database</h4>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                    Download a full backup of all current products, categories, and orders. Keep this to sync inventory between your online Vercel store and your local developer machine.
                </p>
            </div>

            <div class="space-y-2 pt-2 border-t border-gray-100">
                <a href="{{ route('admin.database.download') }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-bold bg-brand-cream hover:bg-gray-100 text-brand-maroon border border-brand-creamBorder transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-brand-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Database (.sqlite)
                </a>
                <div class="text-[10px] text-center text-gray-400">
                    Safe one-click export containing all catalog items
                </div>
            </div>
        </div>

    </div>
</div>
@endsection