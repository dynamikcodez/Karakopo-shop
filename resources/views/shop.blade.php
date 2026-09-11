@extends('layouts.app')

@section('title', 'Shop All Products | Karakopo')
@section('meta_description', 'Browse Karakopo curated household utilities, kitchen essentials, and gifts. Spend less, buy more.')

@section('content')
<div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Shop Collection</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Browse quality household utilities, kitchen essentials, and thoughtful gifts.</p>
        
        <!-- Mobile Horizontal Category Chips (Quick scroll) -->
        <div class="mt-4 flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none md:hidden">
            <a href="{{ route('shop') }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-colors {{ !request('category') ? 'bg-maroon text-white shadow' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All Products
            </a>
            @foreach($categories as $category)
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-colors {{ request('category') == $category->slug ? 'bg-maroon text-white shadow' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="flex flex-col md:flex-row gap-6 lg:gap-8">
        <!-- Desktop Sidebar Filters / Mobile Dropdown -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('shop', [], false) }}" method="GET" id="filter-form">
                    <!-- Search Input -->
                    <div class="mb-5">
                        <label for="search-input" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Search</label>
                        <div class="relative">
                            <input type="text" id="search-input" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-xl focus:border-maroon focus:ring-maroon">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>

                    <!-- Category Filter (Desktop) -->
                    <div class="hidden md:block mb-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-3">Categories</h3>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a href="{{ route('shop') }}" class="flex items-center justify-between py-1 px-2 rounded-lg transition-colors {{ !request('category') ? 'bg-cream text-maroon font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <span>All Categories</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="flex items-center justify-between py-1 px-2 rounded-lg transition-colors {{ request('category') == $category->slug ? 'bg-cream text-maroon font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <span>{{ $category->name }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Sort Filter -->
                    <div class="mb-5">
                        <label for="sort-select" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Sort By</label>
                        <select id="sort-select" name="sort" onchange="document.getElementById('filter-form').submit()" class="w-full text-sm border border-gray-300 rounded-xl py-2 px-3 focus:border-maroon focus:ring-maroon bg-white">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>✨ Latest Arrivals</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>💵 Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💎 Price: High to Low</option>
                        </select>
                    </div>

                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    
                    <button type="submit" class="w-full bg-maroon text-white text-sm font-bold py-2.5 px-4 rounded-xl hover-bg-maroon transition-colors shadow">
                        Apply Filter
                    </button>
                    @if(request('search') || request('category') || request('sort'))
                        <a href="{{ route('shop') }}" class="block text-center text-xs text-gray-500 hover:text-maroon mt-3 underline">
                            Clear Filters
                        </a>
                    @endif
                </form>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-6">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-16 px-4 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-cream text-maroon rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No products found</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">We couldn't find items matching your search. Try different keywords or clear category filters.</p>
                    <a href="{{ route('shop') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-maroon text-white text-sm font-bold shadow hover-bg-maroon transition-colors">
                        Reset All Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
