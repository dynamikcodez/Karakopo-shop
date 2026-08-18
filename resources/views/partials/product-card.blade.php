<a href="{{ route('product.show', $product->slug) }}" class="group block relative bg-white border border-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
    <!-- Image -->
    <div class="aspect-square bg-gray-100 relative overflow-hidden">
        @if($product->primaryImage)
            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300 group-hover:scale-105 transition-transform duration-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
        @if($product->sale_price && $product->sale_price < $product->price)
            <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">SALE</div>
        @endif
    </div>
    
    <!-- Info -->
    <div class="p-4">
        <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 mb-1 group-hover:text-maroon transition-colors">{{ $product->name }}</h3>
        <div class="flex items-center space-x-2">
            @if($product->sale_price && $product->sale_price < $product->price)
                <span class="text-lg font-bold text-gray-900">₦{{ number_format($product->sale_price, 2) }}</span>
                <span class="text-sm text-gray-400 line-through">₦{{ number_format($product->price, 2) }}</span>
            @else
                <span class="text-lg font-bold text-gray-900">₦{{ number_format($product->price, 2) }}</span>
            @endif
        </div>
    </div>
</a>
