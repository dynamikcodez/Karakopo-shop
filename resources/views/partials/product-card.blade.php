@php
    $productUrl = route('product.show', $product->slug);
    $isDiscounted = $product->sale_price && $product->sale_price < $product->price;
    $effectivePrice = $isDiscounted ? $product->sale_price : $product->price;
    $percentOff = $isDiscounted ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
    $savings = $isDiscounted ? ($product->price - $product->sale_price) : 0;
@endphp
<div class="group relative bg-white border border-brand-creamBorder rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
    
    <!-- Product Link & Image Area -->
    <a href="{{ $productUrl }}" class="block focus:outline-none flex-1">
        <div class="aspect-square bg-brand-creamSoft relative overflow-hidden">
            <img src="{{ $product->image_url }}" 
                 onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" 
                 class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" 
                 alt="{{ $product->name }}" 
                 loading="lazy">

            <!-- Badges Area -->
            <div class="absolute top-2.5 left-2.5 flex flex-col gap-1.5 items-start">
                @if($isDiscounted)
                    <span class="bg-brand-rose text-white text-[10px] font-black px-2.5 py-0.5 rounded-full shadow-md tracking-wider uppercase">
                        -{{ $percentOff }}%
                    </span>
                @endif
                @if($product->stock <= 5 && $product->stock > 0)
                    <span class="bg-brand-amber text-brand-maroon text-[9px] font-black px-2 py-0.5 rounded-full shadow-sm uppercase">
                        Only {{ $product->stock }} Left
                    </span>
                @endif
            </div>

            <!-- Quick Share Floating Action -->
            <button type="button" 
                    onclick="event.preventDefault(); event.stopPropagation(); if (navigator.share) { navigator.share({title: '{{ addslashes($product->name) }}', url: '{{ $productUrl }}'}); } else { navigator.clipboard.writeText('{{ $productUrl }}'); window.showToast('Product link copied!'); }"
                    class="absolute top-2.5 right-2.5 w-8 h-8 rounded-full bg-white/90 backdrop-blur text-gray-600 hover:text-brand-maroon hover:bg-white shadow-md flex items-center justify-center transition-all opacity-90 sm:opacity-0 group-hover:opacity-100 focus:opacity-100" 
                    title="Share item">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
            </button>
        </div>
        
        <!-- Product Details Area -->
        <div class="p-3 sm:p-4">
            @if($product->category)
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">
                    {{ $product->category->name }}
                </span>
            @endif

            <h3 class="text-xs sm:text-sm font-bold text-gray-900 line-clamp-2 mb-2 group-hover:text-brand-maroon transition-colors leading-snug">
                {{ $product->name }}
            </h3>

            <!-- Price Breakdown -->
            <div class="flex items-baseline flex-wrap gap-x-2 gap-y-0.5">
                <span class="text-sm sm:text-base font-black text-brand-maroon">
                    ₦{{ number_format($effectivePrice) }}
                </span>
                @if($isDiscounted)
                    <span class="text-xs text-gray-400 line-through">
                        ₦{{ number_format($product->price) }}
                    </span>
                @endif
            </div>

            @if($isDiscounted)
                <div class="mt-1 text-[10px] font-semibold text-brand-green">
                    You save ₦{{ number_format($savings) }}
                </div>
            @endif
        </div>
    </a>

    <!-- Action Buttons -->
    <div class="px-3 sm:px-4 pb-3 sm:pb-4 pt-0">
        <form action="{{ route('cart.add', [], false) }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="w-full py-2 px-3 text-xs sm:text-sm font-bold rounded-xl border border-brand-maroon text-brand-maroon hover:bg-brand-maroon hover:text-white transition-colors flex items-center justify-center space-x-1.5 shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>Add to Cart</span>
            </button>
        </form>
    </div>
</div>
