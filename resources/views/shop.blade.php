@extends('layouts.app')

@section('title', 'Shop | Karakopo')

@section('content')
<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900">Shop</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <form action="{{ route('shop') }}" method="GET" id="filter-form">
                <!-- Search -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Find products..." class="w-full border-gray-300 rounded shadow-sm focus:border-maroon focus:ring-maroon p-2 border">
                </div>

                <!-- Categories -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Categories</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>
                            <a href="{{ route('shop') }}" class="{{ !request('category') ? 'text-maroon font-bold' : 'hover:text-maroon' }}">All Categories</a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" class="{{ request('category') == $category->slug ? 'text-maroon font-bold' : 'hover:text-maroon' }}">{{ $category->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Sort -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select name="sort" onchange="document.getElementById('filter-form').submit()" class="w-full border-gray-300 rounded shadow-sm focus:border-maroon focus:ring-maroon p-2 border">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
                
                <button type="submit" class="w-full bg-maroon text-white py-2 rounded hover-bg-maroon transition">Apply Filters</button>
            </form>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1">
            @if($products->count() > 0)
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500">Try adjusting your filters or search term.</p>
                    <a href="{{ route('shop') }}" class="mt-4 inline-block text-maroon hover:underline">Clear all filters</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
