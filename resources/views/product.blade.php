@extends('layouts.app')

@section('title', $product->name . ' | Karakopo')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Breadcrumbs -->
    <nav class="flex text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-maroon">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('shop') }}" class="hover:text-maroon">Shop</a>
        <span class="mx-2">/</span>
        @if($product->category)
        <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-maroon">{{ $product->category->name }}</a>
        <span class="mx-2">/</span>
        @endif
        <span class="text-gray-900 font-medium truncate">{{ $product->name }}</span>
    </nav>

    <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
        <!-- Images -->
        <div class="mb-8 lg:mb-0">
            <div class="aspect-square rounded-lg bg-gray-100 overflow-hidden mb-4 border border-gray-200">
                @if($product->images->count() > 0)
                    @php $primary = $product->images->where('is_primary', true)->first() ?? $product->images->first(); @endphp
                    <img src="{{ asset('storage/' . $primary->image_path) }}" id="main-image" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
            </div>
            <!-- Thumbnails -->
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-4">
                @foreach($product->images as $image)
                    <button type="button" class="aspect-square rounded-md bg-gray-100 overflow-hidden border border-gray-200 hover:border-maroon focus:outline-none focus:ring-2 focus:ring-maroon focus:ring-offset-2" onclick="document.getElementById('main-image').src='{{ asset('storage/' . $image->image_path) }}'">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Details -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $product->name }}</h1>
            <p class="mt-2 text-sm text-gray-500">SKU: {{ $product->sku }}</p>

            <div class="mt-6 flex items-center">
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="text-3xl font-bold text-gray-900">₦{{ number_format($product->sale_price, 2) }}</span>
                    <span class="ml-4 text-xl text-gray-400 line-through">₦{{ number_format($product->price, 2) }}</span>
                    <span class="ml-4 bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">SALE</span>
                @else
                    <span class="text-3xl font-bold text-gray-900">₦{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            @if($product->short_description)
            <div class="mt-6 text-gray-700">
                <p>{{ $product->short_description }}</p>
            </div>
            @endif

            <div class="mt-6">
                @if($product->stock > 0)
                    <p class="text-sm font-medium text-green-600 mb-4">In Stock ({{ $product->stock }} available)</p>
                    
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-6 flex gap-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="w-24">
                            <label for="quantity" class="sr-only">Quantity</label>
                            <select id="quantity" name="quantity" class="w-full border border-gray-300 rounded-md py-3 px-4 text-base focus:outline-none focus:ring-maroon focus:border-maroon sm:text-sm">
                                @for($i = 1; $i <= min($product->stock, 10); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="flex-1 bg-maroon text-white px-8 py-3 rounded-md font-bold hover-bg-maroon transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-maroon">
                            Add to Cart
                        </button>
                    </form>
                @else
                    <p class="text-sm font-medium text-red-600 mb-4">Out of Stock</p>
                    <button disabled class="w-full bg-gray-300 text-gray-500 px-8 py-3 rounded-md font-bold cursor-not-allowed">
                        Out of Stock
                    </button>
                @endif
            </div>

            @if($product->description)
            <div class="mt-10 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Product Details</h3>
                <div class="prose prose-sm text-gray-700">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-24">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">You may also like</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                @include('partials.product-card', ['product' => $related])
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
