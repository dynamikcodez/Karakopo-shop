@extends('layouts.app')

@section('title', 'Karakopo | Spend less. Buy more. — Quality Household & Kitchen Utilities')
@section('meta_description', 'Discover curated kitchen utilities, dining sets, home decor, and souvenir gifts in Nigeria at unbeatable prices. Spend less. Buy more with Karakopo.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-white via-brand-creamSoft to-brand-cream overflow-hidden border-b border-brand-creamBorder">
    <!-- Subtle luxury decorative blobs -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-rose/5 rounded-full blur-3xl pointer-events-none -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-brand-amber/5 rounded-full blur-3xl pointer-events-none -ml-24 -mb-24"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-16 pb-16 lg:pb-24 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Column: Copy & Value Proposition -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <!-- Tagline Badge -->
                <div class="inline-flex items-center space-x-2 bg-brand-cream border border-brand-creamBorder px-3.5 py-1.5 rounded-full shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-brand-rose animate-ping"></span>
                    <span class="text-xs font-bold text-brand-maroon tracking-wide uppercase">Smart Nigerian Living</span>
                    <span class="text-xs text-gray-400">|</span>
                    <span class="text-xs text-brand-green font-semibold">Direct Supplier Rates</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 tracking-tight leading-[1.1]">
                    Spend less. <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-maroon via-brand-rose to-brand-amber">
                        Buy more.
                    </span>
                </h1>

                <p class="text-base sm:text-lg text-gray-600 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Carefully curated household items, kitchenware essentials, and premium souvenirs. Premium quality, modern aesthetics, and unbeatable value — all in one trusted store.
                </p>

                <!-- Dual Action CTAs -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5">
                    <a href="{{ route('shop') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-2xl bg-brand-maroon hover-bg-maroon text-white font-extrabold text-sm sm:text-base shadow-brand hover:shadow-brand-hover transition-all duration-200 group">
                        <span>Shop Catalog</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20I%20am%20interested%20in%20ordering%20household%20items" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 rounded-2xl bg-brand-green hover:bg-brand-greenLight text-white font-bold text-sm sm:text-base shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                        <span>Order via WhatsApp</span>
                    </a>
                </div>

                <!-- Trust Micro-Badges -->
                <div class="pt-4 grid grid-cols-3 gap-2 sm:gap-4 text-left max-w-lg mx-auto lg:mx-0 border-t border-brand-creamBorder">
                    <div>
                        <div class="font-black text-base sm:text-lg text-brand-maroon">100%</div>
                        <div class="text-[11px] sm:text-xs text-gray-500 leading-tight">Authentic Quality</div>
                    </div>
                    <div>
                        <div class="font-black text-base sm:text-lg text-brand-maroon">Fast</div>
                        <div class="text-[11px] sm:text-xs text-gray-500 leading-tight">Nationwide Delivery</div>
                    </div>
                    <div>
                        <div class="font-black text-base sm:text-lg text-brand-maroon">Direct</div>
                        <div class="text-[11px] sm:text-xs text-gray-500 leading-tight">WhatsApp Support</div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Visual Showcase -->
            <div class="lg:col-span-5">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <!-- Main Frame -->
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white aspect-[4/3] sm:aspect-square bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1584984164101-70ee5fec7db3?q=80&w=1200&auto=format&fit=crop" 
                             alt="Warm curated household essentials" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <span class="inline-block bg-brand-rose text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase mb-1">
                                Handpicked
                            </span>
                            <h3 class="text-lg font-bold">Kitchen & Dining Collections</h3>
                            <p class="text-xs text-white/80">Elegance meets everyday durability</p>
                        </div>
                    </div>

                    <!-- Floating Badge 1: Savings -->
                    <div class="absolute -top-4 -left-4 bg-white/95 backdrop-blur px-4 py-2.5 rounded-2xl shadow-xl border border-brand-creamBorder flex items-center space-x-3 hidden sm:flex">
                        <div class="w-9 h-9 rounded-xl bg-brand-amber/15 text-brand-amberDark flex items-center justify-center font-bold text-lg">
                            🏷️
                        </div>
                        <div>
                            <div class="text-xs font-black text-gray-900">Spend Less Guarantee</div>
                            <div class="text-[10px] text-gray-500">Unbeatable bulk discounts</div>
                        </div>
                    </div>

                    <!-- Floating Badge 2: Delivery -->
                    <div class="absolute -bottom-4 -right-4 bg-white/95 backdrop-blur px-4 py-2.5 rounded-2xl shadow-xl border border-brand-creamBorder flex items-center space-x-3 hidden sm:flex">
                        <div class="w-9 h-9 rounded-xl bg-brand-green/15 text-brand-green flex items-center justify-center font-bold text-lg">
                            🚚
                        </div>
                        <div>
                            <div class="text-xs font-black text-gray-900">Doorstep Dispatch</div>
                            <div class="text-[10px] text-gray-500">Fast delivery across Nigeria</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 4 Core Pillars Bar -->
<section class="bg-white border-b border-brand-creamBorder py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-2xl bg-brand-cream flex items-center justify-center text-xl flex-shrink-0 border border-brand-creamBorder">
                    🚚
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-gray-900">Nationwide Shipping</h4>
                    <p class="text-[11px] text-gray-500">Prompt delivery across Nigeria</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-2xl bg-brand-cream flex items-center justify-center text-xl flex-shrink-0 border border-brand-creamBorder">
                    🛡️
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-gray-900">Quality Verified</h4>
                    <p class="text-[11px] text-gray-500">Every piece hand-checked</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-2xl bg-brand-cream flex items-center justify-center text-xl flex-shrink-0 border border-brand-creamBorder">
                    💰
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-gray-900">Wholesale Prices</h4>
                    <p class="text-[11px] text-gray-500">Spend less on top utilities</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-2xl bg-brand-cream flex items-center justify-center text-xl flex-shrink-0 border border-brand-creamBorder">
                    💬
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-gray-900">WhatsApp Ordering</h4>
                    <p class="text-[11px] text-gray-500">Chat with us anytime</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Shop by Category Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-3">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-brand-rose">Curated Catalog</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Shop by Category</h2>
        </div>
        <a href="{{ route('shop') }}" class="inline-flex items-center text-xs sm:text-sm font-bold text-brand-maroon hover:text-brand-rose transition-colors">
            <span>Browse all categories</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop', ['category' => $category->slug]) }}" 
           class="group relative rounded-2xl overflow-hidden bg-white border border-brand-creamBorder shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between aspect-[4/5]">
            <img src="{{ $category->image_url }}" 
                 onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" 
                 class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500"
                 alt="{{ $category->name }}"
                 loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent flex flex-col justify-end p-4 text-white">
                <h3 class="font-black text-sm sm:text-base leading-tight drop-shadow">{{ $category->name }}</h3>
                <span class="text-[11px] text-white/80 group-hover:text-brand-amber transition-colors mt-1 font-medium flex items-center">
                    Explore &rarr;
                </span>
            </div>
        </a>
        @endforeach
    </div>
</section>

<!-- Featured Products Showcase -->
<section class="bg-white border-y border-brand-creamBorder py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-black uppercase tracking-wider text-brand-green">Handpicked Selection</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Featured Products</h2>
            </div>
            <a href="{{ route('shop') }}" class="hidden sm:inline-flex items-center text-sm font-bold text-brand-maroon hover:text-brand-rose transition-colors">
                <span>View all products ({{ \App\Models\Product::where('is_published', true)->count() }})</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3.5 sm:gap-6">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-8 text-center sm:hidden">
            <a href="{{ route('shop') }}" class="inline-block px-6 py-2.5 rounded-xl bg-brand-cream border border-brand-creamBorder text-brand-maroon text-xs font-bold">
                View Full Catalog &rarr;
            </a>
        </div>
    </div>
</section>

<!-- Promotional "Spend Less. Buy More" Savings Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
    <div class="bg-gradient-to-r from-brand-maroon via-brand-maroonDark to-[#28000C] text-white rounded-3xl p-8 sm:p-12 shadow-2xl relative overflow-hidden">
        <!-- Background decorative rings -->
        <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-brand-rose/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -top-16 w-80 h-80 bg-brand-amber/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl space-y-4">
            <span class="inline-block bg-brand-amber text-brand-maroon text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider">
                🏷️ Direct Household Savings
            </span>
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                Planning bulk souvenirs or refreshing your kitchen?
            </h2>
            <p class="text-sm sm:text-base text-white/85 leading-relaxed">
                Whether you need corporate gifts, wedding souvenirs, or complete dining essentials for your home, Karakopo offers special packaged deals to save you even more.
            </p>
            <div class="pt-3 flex flex-wrap items-center gap-3">
                <a href="{{ route('shop') }}" class="px-6 py-3 bg-white hover:bg-gray-100 text-brand-maroon font-bold text-sm rounded-xl shadow transition-colors">
                    Browse All Products
                </a>
                <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20I%20want%20to%20inquire%20about%20bulk%20orders%20and%20souvenirs" target="_blank" rel="noopener noreferrer" class="px-6 py-3 bg-brand-green hover:bg-brand-greenLight text-white font-bold text-sm rounded-xl shadow transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                    Chat for Bulk Rates
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Popular Right Now -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="flex items-end justify-between mb-8">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-brand-amber">Trending Now</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Popular Right Now</h2>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-6">
        @foreach($popularProducts as $product)
            @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>
</section>

<!-- WhatsApp VIP Club / Newsletter -->
<section class="bg-brand-cream border-t border-brand-creamBorder py-12">
    <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-green-100 text-brand-green flex items-center justify-center mx-auto text-2xl">
            💬
        </div>
        <h3 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
            Never Miss a Karakopo Flash Deal!
        </h3>
        <p class="text-xs sm:text-sm text-gray-600 max-w-md mx-auto">
            Join hundreds of smart shoppers who get early notification on new kitchenware arrivals, price drops, and clearance sales.
        </p>
        <div class="pt-2">
            <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20please%20add%20me%20to%20your%20deals%20broadcast" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-6 py-3 rounded-2xl bg-brand-green hover:bg-brand-greenLight text-white text-xs sm:text-sm font-bold shadow-md transition-all">
                <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                Join WhatsApp Deals Broadcast
            </a>
        </div>
    </div>
</section>
@endsection
