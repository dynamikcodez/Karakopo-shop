@php
    $productUrl = route('product.show', $product->slug);
    $price = $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price;
    $hasDiscount = $product->sale_price && $product->sale_price < $product->price;
@endphp
<div class="group relative bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
    <a href="{{ $productUrl }}" class="block focus:outline-none">
        <!-- Image Area -->
        <div class="aspect-square bg-gray-50 relative overflow-hidden">
            <img src="{{ $product->image_url }}" 
                 onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" 
                 class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300" 
                 alt="{{ $product->name }}" 
                 loading="lazy">

            <!-- Sale Badge -->
            @if($hasDiscount)
                <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] sm:text-xs font-extrabold px-2 py-0.5 rounded shadow">
                    SALE
                </div>
            @endif

            <!-- Quick Share Floating Button -->
            <button type="button" 
                    onclick="event.preventDefault(); event.stopPropagation(); if (navigator.share) { navigator.share({title: '{{ addslashes($product->name) }}', url: '{{ $productUrl }}'}); } else { navigator.clipboard.writeText('{{ $productUrl }}'); window.showToast('Product link copied!'); }"
                    class="absolute top-2 right-2 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/90 backdrop-blur text-gray-600 hover:text-maroon hover:bg-white shadow flex items-center justify-center transition-all opacity-90 sm:opacity-0 group-hover:opacity-100 focus:opacity-100" 
                    title="Share item">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
            </button>
        </div>
        
        <!-- Info Area -->
        <div class="p-3 sm:p-4">
            <h3 class="text-xs sm:text-sm font-semibold text-gray-800 line-clamp-2 mb-1.5 group-hover:text-maroon transition-colors">
                {{ $product->name }}
            </h3>
            <div class="flex items-baseline space-x-1.5 sm:space-x-2">
                <span class="text-base sm:text-lg font-black text-gray-900">₦{{ number_format($price, 2) }}</span>
                @if($hasDiscount)
                    <span class="text-xs text-gray-400 line-through">₦{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
        </div>
    </a>

    <!-- Add to Cart / View Button -->
    <div class="px-3 sm:px-4 pb-3 sm:pb-4 pt-0">
        <form action="{{ route('cart.add', [], false) }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="w-full py-2 px-3 text-xs sm:text-sm font-bold rounded-lg border border-maroon text-maroon hover:bg-maroon hover:text-white transition-colors flex items-center justify-center space-x-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>Add to Cart</span>
            </button>
        </form>
    </div>
</div>
