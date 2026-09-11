@extends('layouts.app')

@section('title', $product->name . ' | Karakopo')
@section('meta_description', $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 150))
@section('meta_image', $product->image_url)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-12">
    <!-- Breadcrumbs -->
    <nav class="flex text-xs sm:text-sm text-gray-500 mb-6 overflow-x-auto whitespace-nowrap pb-2">
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

    <!-- Admin Promotional Banner (Visible when Admin is logged in) -->
    @if(auth()->check() && auth()->user()->is_admin)
        @php
            $shareUrl = route('product.show', $product->slug);
            $effectivePrice = $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price;
            $wasPriceStr = $product->sale_price && $product->sale_price < $product->price ? " (was ₦" . number_format($product->price) . ")" : "";
            $promoCaption = "✨ *" . $product->name . "* ✨\n"
                          . ($product->short_description ? $product->short_description . "\n\n" : "")
                          . "💰 *Price:* ₦" . number_format($effectivePrice) . $wasPriceStr . "\n"
                          . "📦 Stock: " . $product->stock . " units available\n"
                          . "🚚 Fast delivery across Nigeria.\n\n"
                          . "🛒 *Order now on Karakopo:* " . $shareUrl . "\n\n"
                          . "Karakopo — Spend less. Buy more. 🛍️";
        @endphp
        <div class="mb-8 bg-gradient-to-r from-[#5B1032] to-[#7a1543] text-white p-5 rounded-2xl shadow-lg border border-maroon/20">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="inline-block bg-white/20 text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider mb-1">Admin Tools</span>
                    <h3 class="text-lg font-bold">📢 Promotional Social Caption & Link</h3>
                    <p class="text-xs text-white/80">Instantly share this product to WhatsApp statuses, broadcast groups, and Telegram channels.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" onclick="copyPromoText(`{{ addslashes($promoCaption) }}`)" class="inline-flex items-center px-4 py-2 bg-white text-maroon text-xs sm:text-sm font-bold rounded-lg hover:bg-gray-100 shadow transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        Copy Promo Copy & Link
                    </button>
                    <a href="https://wa.me/?text={{ urlencode($promoCaption) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-bold rounded-lg shadow transition-colors">
                        <svg class="w-4 h-4 mr-1.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                        Share to WhatsApp
                    </a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center px-3 py-2 bg-white/15 hover:bg-white/25 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors">
                        ✏️ Edit in Admin
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
        <!-- Product Images -->
        <div class="mb-8 lg:mb-0">
            <div class="aspect-square rounded-2xl bg-white overflow-hidden mb-4 border border-gray-100 shadow-sm relative">
                @if($product->images->count() > 0)
                    @php $primary = $product->images->where('is_primary', true)->first() ?? $product->images->first(); @endphp
                    <img src="{{ $primary ? $primary->url : $product->image_url }}" id="main-image" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';" class="w-full h-full object-cover transition-all duration-300" alt="{{ $product->name }}">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-50">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-xs text-gray-400 mt-2">Karakopo Essentials</span>
                    </div>
                @endif
                @if($product->sale_price && $product->sale_price < $product->price)
                    <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-black px-3 py-1.5 rounded-full shadow-md">
                        SALE
                    </div>
                @endif
            </div>

            <!-- Thumbnails -->
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                @foreach($product->images as $image)
                    <button type="button" class="aspect-square rounded-xl bg-white overflow-hidden border-2 border-gray-200 hover:border-maroon focus:outline-none focus:border-maroon transition-all shadow-sm" onclick="document.getElementById('main-image').src='{{ $image->url }}'">
                        <img src="{{ $image->url }}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';" class="w-full h-full object-cover" alt="Thumbnail">
                    </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="flex flex-col">
            @if($product->category)
                <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="text-xs uppercase font-bold tracking-wider text-maroon hover:underline mb-1">
                    {{ $product->category->name }}
                </a>
            @endif

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                {{ $product->name }}
            </h1>
            
            <div class="flex items-center space-x-3 mt-2 text-xs text-gray-500">
                <span>SKU: <strong class="text-gray-700">{{ $product->sku }}</strong></span>
                <span>•</span>
                @if($product->stock > 0)
                    <span class="inline-flex items-center text-green-700 font-semibold">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5 animate-pulse"></span>
                        In Stock ({{ $product->stock }} left)
                    </span>
                @else
                    <span class="inline-flex items-center text-red-600 font-semibold">
                        <span class="w-2 h-2 rounded-full bg-red-500 mr-1.5"></span>
                        Out of Stock
                    </span>
                @endif
            </div>

            <!-- Pricing -->
            <div class="mt-5 p-4 rounded-xl bg-white border border-gray-100 shadow-sm flex items-baseline space-x-4">
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="text-3xl sm:text-4xl font-black text-gray-900">₦{{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-lg sm:text-xl text-gray-400 line-through">₦{{ number_format($product->price, 2) }}</span>
                    <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded">
                        Save ₦{{ number_format($product->price - $product->sale_price, 2) }}
                    </span>
                @else
                    <span class="text-3xl sm:text-4xl font-black text-gray-900">₦{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            @if($product->short_description)
            <div class="mt-5 text-sm sm:text-base text-gray-600 leading-relaxed">
                <p>{{ $product->short_description }}</p>
            </div>
            @endif

            <!-- Add to Cart Form -->
            <div class="mt-6">
                @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="w-full sm:w-28">
                            <label for="quantity" class="block text-xs font-semibold text-gray-700 mb-1">Quantity</label>
                            <select id="quantity" name="quantity" class="w-full border border-gray-300 rounded-xl py-3.5 px-3 text-base font-semibold focus:outline-none focus:ring-2 focus:ring-maroon focus:border-maroon bg-white shadow-sm">
                                @for($i = 1; $i <= min($product->stock, 10); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="flex-1 sm:self-end">
                            <button type="submit" class="w-full bg-maroon text-white py-3.5 px-8 rounded-xl font-bold text-base hover-bg-maroon transition-all shadow-md hover:shadow-lg flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="p-4 bg-red-50 text-red-700 rounded-xl text-center font-medium text-sm">
                        This item is currently sold out. Check back soon!
                    </div>
                @endif
            </div>

            <!-- Social Share Tray (User-Facing) -->
            @php
                $currentUrl = url()->current();
                $sharePrice = $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price;
                $userShareText = "Check out " . $product->name . " on Karakopo for ₦" . number_format($sharePrice) . "! " . $currentUrl;
            @endphp
            <div class="mt-8 pt-6 border-t border-gray-200">
                <span class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Share this product:</span>
                <div class="flex flex-wrap items-center gap-2">
                    <!-- Native Mobile Share Button -->
                    <button type="button" onclick="triggerNativeShare('{{ addslashes($product->name) }}', '{{ addslashes($userShareText) }}', '{{ $currentUrl }}')" class="inline-flex items-center px-3.5 py-2 rounded-lg bg-gray-900 text-white text-xs font-semibold hover:bg-black transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        Share
                    </button>

                    <!-- WhatsApp Button -->
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($userShareText) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-2 rounded-lg bg-[#25D366] hover:bg-[#20ba59] text-white text-xs font-semibold transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-1.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                        WhatsApp
                    </a>

                    <!-- Telegram Button -->
                    <a href="https://t.me/share/url?url={{ urlencode($currentUrl) }}&text={{ urlencode('Check out ' . $product->name . ' on Karakopo!') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-2 rounded-lg bg-[#0088cc] hover:bg-[#0077b5] text-white text-xs font-semibold transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-1.5 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.52 2.77-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                        Telegram
                    </a>

                    <!-- Twitter / X Button -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($userShareText) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-2 rounded-lg bg-black hover:bg-gray-800 text-white text-xs font-semibold transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-1.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        X
                    </a>

                    <!-- Copy Link Button -->
                    <button type="button" onclick="copyToClipboard('{{ $currentUrl }}', 'Product link copied!')" class="inline-flex items-center px-3 py-2 rounded-lg bg-white hover:bg-gray-100 text-gray-700 text-xs font-semibold border border-gray-300 transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Copy Link
                    </button>
                </div>
            </div>

            <!-- Detailed Description -->
            @if($product->description)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-base font-bold text-gray-900 mb-3">Product Description</h3>
                <div class="prose prose-sm text-gray-700 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-16 sm:mt-24 pt-8 border-t border-gray-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">You May Also Like</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($relatedProducts as $related)
                @include('partials.product-card', ['product' => $related])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Copy link helper with toast
    function copyToClipboard(text, successMsg = 'Copied to clipboard!') {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                window.showToast(successMsg);
            }).catch(() => fallbackCopy(text, successMsg));
        } else {
            fallbackCopy(text, successMsg);
        }
    }

    function fallbackCopy(text, successMsg) {
        const temp = document.createElement('textarea');
        temp.value = text;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        window.showToast(successMsg);
    }

    function copyPromoText(caption) {
        copyToClipboard(caption, 'Promotional caption & link copied!');
    }

    // Native Web Share API trigger
    function triggerNativeShare(title, text, url) {
        if (navigator.share) {
            navigator.share({
                title: title,
                text: text,
                url: url
            }).catch((err) => {
                if (err.name !== 'AbortError') {
                    copyToClipboard(url, 'Link copied to clipboard!');
                }
            });
        } else {
            copyToClipboard(url, 'Link copied to clipboard!');
        }
    }
</script>
@endpush
@endsection
