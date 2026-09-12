@extends('layouts.app')

@section('title', 'Shop Catalog | Karakopo — Spend less. Buy more.')
@section('meta_description', 'Browse Karakopo curated household utilities, kitchen essentials, dining ware, and gift souvenirs in Nigeria with fast delivery.')

@section('content')
<!-- Page Header & Breadcrumbs -->
<div class="bg-white border-b border-brand-creamBorder shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <nav aria-label="Breadcrumb" class="flex text-xs text-gray-500 mb-2">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-brand-maroon">Home</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-900 font-semibold">Shop Catalog</li>
                @if(request('category'))
                    @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
                    @if($activeCat)
                        <li class="text-gray-300">/</li>
                        <li class="text-brand-rose font-bold">{{ $activeCat->name }}</li>
                    @endif
                @endif
            </ol>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    @if(request('category') && isset($activeCat))
                        {{ $activeCat->name }}
                    @elseif(request('search'))
                        Search results for "{{ request('search') }}"
                    @else
                        Shop Collection
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Quality household utilities, durable kitchen essentials, and curated souvenirs.
                </p>
            </div>
            
            <div class="text-xs font-semibold text-gray-500">
                Showing <strong class="text-gray-900">{{ $products->total() }}</strong> {{ Str::plural('product', $products->total()) }}
            </div>
        </div>
        
        <!-- Mobile Horizontal Category Chips -->
        <div class="mt-4 flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none md:hidden">
            <a href="{{ route('shop') }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-colors {{ !request('category') ? 'bg-brand-maroon text-white shadow' : 'bg-brand-cream text-gray-700 hover:bg-gray-200 border border-brand-creamBorder' }}">
                All Items
            </a>
            @foreach($categories as $category)
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-colors {{ request('category') == $category->slug ? 'bg-brand-maroon text-white shadow' : 'bg-brand-cream text-gray-700 hover:bg-gray-200 border border-brand-creamBorder' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Main Shop Content Area -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
    <div class="flex flex-col md:flex-row gap-6 lg:gap-8 items-start">
        
        <!-- Desktop Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white p-5 rounded-2xl shadow-brand border border-brand-creamBorder space-y-6">
                <form action="{{ route('shop', [], false) }}" method="GET" id="filter-form">
                    
                    <!-- Search Input -->
                    <div class="mb-5">
                        <label for="search-input" class="block text-xs font-black uppercase tracking-wider text-brand-maroon mb-2">
                            Search Products
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="search-input" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="e.g. Plate, Knife, Flask..." 
                                   class="w-full pl-9 pr-3 py-2 text-xs border border-gray-200 rounded-xl focus:border-brand-maroon focus:ring-brand-maroon">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>

                    <!-- Category Filter (Desktop) -->
                    <div class="hidden md:block mb-5">
                        <h3 class="text-xs font-black uppercase tracking-wider text-brand-maroon mb-2.5">Categories</h3>
                        <ul class="space-y-1 text-xs">
                            <li>
                                <a href="{{ route('shop') }}" class="flex items-center justify-between py-1.5 px-2.5 rounded-lg font-medium transition-colors {{ !request('category') ? 'bg-brand-cream text-brand-maroon font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <span>All Categories</span>
                                    <span class="text-[10px] text-gray-400 font-normal">{{ \App\Models\Product::where('is_published', true)->count() }}</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="flex items-center justify-between py-1.5 px-2.5 rounded-lg font-medium transition-colors {{ request('category') == $category->slug ? 'bg-brand-cream text-brand-maroon font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-[10px] text-gray-400 font-normal">{{ $category->products()->where('is_published', true)->count() }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Sort Filter -->
                    <div class="mb-5">
                        <label for="sort-select" class="block text-xs font-black uppercase tracking-wider text-brand-maroon mb-2">Sort Collection</label>
                        <select id="sort-select" name="sort" onchange="document.getElementById('filter-form').submit()" class="w-full text-xs border border-gray-200 rounded-xl py-2 px-3 focus:border-brand-maroon focus:ring-brand-maroon bg-white">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>✨ Latest Arrivals</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>💵 Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💎 Price: High to Low</option>
                        </select>
                    </div>

                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    
                    <button type="submit" class="w-full bg-brand-maroon hover-bg-maroon text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow transition-colors">
                        Apply Filter
                    </button>

                    @if(request('search') || request('category') || request('sort'))
                        <a href="{{ route('shop') }}" class="block text-center text-xs text-brand-rose hover:underline mt-3 font-semibold">
                            Reset All Filters
                        </a>
                    @endif
                </form>

                <!-- Bulk Ordering Box -->
                <div class="bg-brand-cream p-4 rounded-xl border border-brand-creamBorder text-xs space-y-2">
                    <div class="font-bold text-brand-maroon flex items-center gap-1.5">
                        <span>📦</span>
                        <span>Buying in Bulk?</span>
                    </div>
                    <p class="text-gray-600 text-[11px] leading-relaxed">
                        Need quantities for events or souvenirs? We provide direct wholesale pricing.
                    </p>
                    <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20I%20need%20bulk%20pricing%20information" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-brand-green font-bold text-[11px] hover:underline">
                        Inquire on WhatsApp &rarr;
                    </a>
                </div>
            </div>
        </aside>

        <!-- Products Grid Area -->
        <main class="flex-1 w-full">
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-6">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-16 px-4 bg-white rounded-3xl shadow-sm border border-brand-creamBorder">
                    <div class="w-16 h-16 bg-brand-cream text-brand-maroon rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        🔍
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">No matching products found</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-sm mx-auto">
                        We couldn't find any items matching your criteria. Try searching for a different keyword or view all categories.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-brand-maroon hover-bg-maroon text-white text-xs font-bold shadow transition-colors">
                            View All Products
                        </a>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
