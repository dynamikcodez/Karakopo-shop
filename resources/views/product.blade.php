@extends('layouts.app')

@php
    $effectivePrice = $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price;
    $isDiscounted = $product->sale_price && $product->sale_price < $product->price;
    $savings = $isDiscounted ? ($product->price - $product->sale_price) : 0;
    $percentOff = $isDiscounted ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
    $metaDesc = $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 160);
@endphp

@section('title', $product->name . ' | Karakopo — Spend less. Buy more.')
@section('meta_description', $metaDesc)
@section('meta_image', $product->image_url)
@section('og_type', 'product')

@section('schema_extra')
<!-- Structured Data for Google Shopping & Breadcrumbs -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org/',
    '@type' => 'Product',
    'name' => $product->name,
    'image' => [$product->image_url],
    'description' => strip_tags($metaDesc),
    'sku' => 'KKP-' . $product->id,
    'brand' => [
        '@type' => 'Brand',
        'name' => 'Karakopo'
    ],
    'offers' => [
        '@type' => 'Offer',
        'url' => url()->current(),
        'priceCurrency' => 'NGN',
        'price' => $effectivePrice,
        'availability' => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        'itemCondition' => 'https://schema.org/NewCondition',
        'seller' => [
            '@type' => 'Organization',
            'name' => 'Karakopo'
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
@php
    $breadcrumbList = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => route('home')
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Shop',
            'item' => route('shop')
        ]
    ];
    if ($product->category) {
        $breadcrumbList[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $product->category->name,
            'item' => route('shop', ['category' => $product->category->slug])
        ];
        $breadcrumbList[] = [
            '@type' => 'ListItem',
            'position' => 4,
            'name' => $product->name,
            'item' => url()->current()
        ];
    } else {
        $breadcrumbList[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $product->name,
            'item' => url()->current()
        ];
    }
@endphp
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $breadcrumbList
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-12">
    
    <!-- Breadcrumbs Navigation -->
    <nav aria-label="Breadcrumbs" class="flex text-xs text-gray-500 mb-6 overflow-x-auto whitespace-nowrap pb-2">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="hover:text-brand-maroon">Home</a></li>
            <li class="text-gray-300">/</li>
            <li><a href="{{ route('shop') }}" class="hover:text-brand-maroon">Shop</a></li>
            @if($product->category)
                <li class="text-gray-300">/</li>
                <li><a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-brand-maroon">{{ $product->category->name }}</a></li>
            @endif
            <li class="text-gray-300">/</li>
            <li class="text-gray-900 font-bold truncate max-w-xs sm:max-w-md">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Admin Promotional Banner (Visible when Admin is logged in) -->
    @if(auth()->check() && auth()->user()->is_admin)
        @php
            $shareUrl = route('product.show', $product->slug);
            $wasPriceStr = $isDiscounted ? " (was ₦" . number_format($product->price) . ")" : "";
            $promoCaption = "✨ *" . $product->name . "* ✨
"
                          . ($product->short_description ? $product->short_description . "

" : "")
                          . "💰 *Price:* ₦" . number_format($effectivePrice) . $wasPriceStr . "
"
                          . "📦 Stock: " . $product->stock . " units available
"
                          . "🚚 Fast delivery across Nigeria.

"
                          . "🛒 *Order now on Karakopo:* " . $shareUrl . "

"
                          . "Karakopo — Spend less. Buy more. 🛍️";
        @endphp
        <div class="mb-8 bg-gradient-to-r from-brand-maroon via-brand-maroonDark to-brand-rose text-white p-5 rounded-3xl shadow-lg border border-white/10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="inline-block bg-white/20 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider mb-1">👑 Admin Fast-Share</span>
                    <h3 class="text-base sm:text-lg font-black">Ready-to-Post WhatsApp Status Caption</h3>
                    <p class="text-xs text-white/80">Copy pre-formatted marketing copy for WhatsApp & Telegram status broadcasts.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" onclick="navigator.clipboard.writeText(`{{ addslashes($promoCaption) }}`); window.showToast('Marketing caption copied!');" class="inline-flex items-center px-4 py-2 bg-white text-brand-maroon text-xs font-bold rounded-xl hover:bg-gray-100 shadow transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        Copy Promo Copy
                    </button>
                    <a href="https://wa.me/?text={{ urlencode($promoCaption) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3.5 py-2 bg-brand-green hover:bg-brand-greenLight text-white text-xs font-bold rounded-xl shadow transition-colors">
                        <svg class="w-4 h-4 mr-1.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                        Share to WhatsApp
                    </a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center px-3 py-2 bg-white/20 hover:bg-white/30 text-white text-xs font-semibold rounded-xl transition-colors">
                        ✏️ Edit Product
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
        
        <!-- Left: Image Gallery (5 cols) -->
        <div class="lg:col-span-6 mb-8 lg:mb-0">
            <div class="aspect-square rounded-3xl bg-white overflow-hidden mb-4 border border-brand-creamBorder shadow-sm relative">
                @if($product->images->count() > 0)
                    @php $primary = $product->images->where('is_primary', true)->first() ?? $product->images->first(); @endphp
                    <img src="{{ $primary ? $primary->url : $product->image_url }}" 
                         id="main-image" 
                         onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';" 
                         class="w-full h-full object-cover transition-all duration-300" 
                         alt="{{ $product->name }}">
                @else
                    <img src="{{ $product->image_url }}" 
                         id="main-image" 
                         onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';" 
                         class="w-full h-full object-cover" 
                         alt="{{ $product->name }}">
                @endif
                
                @if($isDiscounted)
                    <div class="absolute top-4 left-4 bg-brand-rose text-white text-xs font-black px-3 py-1 rounded-full shadow-md tracking-wider">
                        SAVE {{ $percentOff }}%
                    </div>
                @endif
            </div>

            <!-- Thumbnails -->
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                @foreach($product->images as $image)
                    <button type="button" 
                            class="aspect-square rounded-2xl bg-white overflow-hidden border-2 border-brand-creamBorder hover:border-brand-maroon focus:outline-none focus:border-brand-maroon transition-all shadow-sm" 
                            onclick="document.getElementById('main-image').src='{{ $image->url }}'">
                        <img src="{{ $image->url }}" 
                             onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';" 
                             class="w-full h-full object-cover" 
                             alt="Product thumbnail">
                    </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right: Details & Purchase Actions (6 cols) -->
        <div class="lg:col-span-6 flex flex-col space-y-5">
            <div>
                @if($product->category)
                    <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="inline-block text-xs uppercase font-black tracking-wider text-brand-rose hover:underline mb-2">
                        {{ $product->category->name }}
                    </a>
                @endif

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 tracking-tight leading-tight">
                    {{ $product->name }}
                </h1>

                <!-- Stock Badge -->
                <div class="mt-2.5 flex items-center space-x-3 text-xs">
                    @if($product->stock > 0)
                        <span class="inline-flex items-center text-brand-green font-bold">
                            <span class="w-2 h-2 rounded-full bg-brand-green mr-1.5"></span>
                            In Stock ({{ $product->stock }} units available)
                        </span>
                    @else
                        <span class="inline-flex items-center text-brand-rose font-bold">
                            <span class="w-2 h-2 rounded-full bg-brand-rose mr-1.5"></span>
                            Currently Out of Stock
                        </span>
                    @endif
                    <span class="text-gray-300">•</span>
                    <span class="text-gray-500">Fast Nationwide Shipping</span>
                </div>
            </div>

            <!-- Pricing Box -->
            <div class="bg-white p-5 rounded-2xl border border-brand-creamBorder shadow-sm space-y-2">
                <div class="flex items-baseline space-x-3">
                    <span class="text-3xl sm:text-4xl font-black text-brand-maroon">
                        ₦{{ number_format($effectivePrice) }}
                    </span>
                    @if($isDiscounted)
                        <span class="text-base sm:text-lg text-gray-400 line-through">
                            ₦{{ number_format($product->price) }}
                        </span>
                        <span class="bg-brand-rose/10 text-brand-rose text-xs font-bold px-2 py-0.5 rounded-full">
                            Save ₦{{ number_format($savings) }} ({{ $percentOff }}% off)
                        </span>
                    @endif
                </div>
                <p class="text-[11px] text-gray-500">
                    Transparent pricing. Inclusive of all direct packaging for safe transit.
                </p>
            </div>

            <!-- Order Form & Quantity Selector -->
            <form action="{{ route('cart.add', [], false) }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="flex items-center space-x-4">
                    <label for="product-qty" class="text-xs font-bold uppercase tracking-wider text-gray-700">Quantity:</label>
                    <div class="flex items-center border border-gray-200 rounded-xl bg-white overflow-hidden shadow-sm">
                        <button type="button" onclick="let q = document.getElementById('product-qty'); if(q.value > 1) q.value--;" class="px-3 py-2 text-gray-600 hover:bg-gray-100 font-bold focus:outline-none">-</button>
                        <input type="number" id="product-qty" name="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}" class="w-14 text-center text-sm font-bold border-0 focus:ring-0">
                        <button type="button" onclick="let q = document.getElementById('product-qty'); if(q.value < {{ max(1, $product->stock) }}) q.value++;" class="px-3 py-2 text-gray-600 hover:bg-gray-100 font-bold focus:outline-none">+</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <button type="submit" class="w-full py-3.5 px-6 rounded-2xl bg-brand-maroon hover-bg-maroon text-white font-black text-sm shadow-brand hover:shadow-brand-hover transition-all flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Add to Cart</span>
                    </button>

                    @php
                        $waDirectMessage = "Hello Karakopo! I would like to order *" . $product->name . "* (₦" . number_format($effectivePrice) . "). Product link: " . url()->current();
                    @endphp
                    <a href="https://wa.me/2348126215642?text={{ urlencode($waDirectMessage) }}" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 px-6 rounded-2xl bg-brand-green hover:bg-brand-greenLight text-white font-black text-sm shadow-sm transition-all flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                        <span>Direct WhatsApp Buy</span>
                    </a>
                </div>
            </form>

            <!-- Trust Perks Box -->
            <div class="border-t border-brand-creamBorder pt-5 grid grid-cols-2 gap-3 text-xs text-gray-600">
                <div class="flex items-center space-x-2">
                    <span class="text-base">🚚</span>
                    <span>Doorstep Delivery in Nigeria</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-base">🛡️</span>
                    <span>100% Quality Inspected</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-base">🏦</span>
                    <span>Simple Bank Transfer (OPay)</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-base">💬</span>
                    <span>Direct Live WhatsApp Support</span>
                </div>
            </div>

            <!-- Product Description Tab Section -->
            <div class="border-t border-brand-creamBorder pt-6 space-y-4">
                <h3 class="text-xs font-black uppercase tracking-widest text-brand-maroon">
                    Product Details & Overview
                </h3>
                <div class="prose prose-sm text-xs sm:text-sm text-gray-600 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-16 sm:mt-24 border-t border-brand-creamBorder pt-12">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-black uppercase tracking-wider text-brand-rose">You Might Also Need</span>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Related Household Items</h2>
            </div>
            <a href="{{ route('shop') }}" class="text-xs sm:text-sm font-bold text-brand-maroon hover:underline">
                View All &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-6">
            @foreach($relatedProducts as $related)
                @include('partials.product-card', ['product' => $related])
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
