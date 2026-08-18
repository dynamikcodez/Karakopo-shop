@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-[#5B1032]">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Sales</h3>
        <p class="text-3xl font-bold mt-2">₦{{ number_format($stats['total_sales'], 2) }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Orders</h3>
        <p class="text-3xl font-bold mt-2">{{ $stats['orders_count'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Pending Orders</h3>
        <p class="text-3xl font-bold mt-2">{{ $stats['pending_orders'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Completed Orders</h3>
        <p class="text-3xl font-bold mt-2">{{ $stats['completed_orders'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Products</h3>
        <p class="text-3xl font-bold mt-2">{{ $stats['product_count'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Low Stock Alerts</h3>
        <p class="text-3xl font-bold mt-2">{{ $stats['low_stock'] }}</p>
    </div>
</div>
@endsection
