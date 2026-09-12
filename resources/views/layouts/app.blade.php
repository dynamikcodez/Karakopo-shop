<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    
    <!-- Primary SEO Metadata -->
    <title>@yield('title', 'Karakopo | Spend less. Buy more. — Household Utilities & Gifts in Nigeria')</title>
    <meta name="description" content="@yield('meta_description', 'Spend less. Buy more. Shop curated premium household utilities, kitchen essentials, and thoughtful souvenirs in Nigeria with fast nationwide delivery.')">
    <meta name="keywords" content="household items Nigeria, kitchen utensils Lagos, affordable home utilities, souvenirs Abuja, corporate gifts Nigeria, Karakopo shop, online shopping Nigeria, spend less buy more">
    <meta name="author" content="Karakopo">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    
    <!-- Favicon & Web App Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#520118">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Karakopo">

    <!-- Open Graph (Facebook, WhatsApp, LinkedIn, Telegram) -->
    <meta property="og:site_name" content="Karakopo">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'Karakopo | Spend less. Buy more.')">
    <meta property="og:description" content="@yield('meta_description', 'Spend less. Buy more. Curated household utilities and premium gift items in Nigeria.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-banner.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Karakopo - Spend less. Buy more.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="en_NG">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Karakopo | Spend less. Buy more.')">
    <meta name="twitter:description" content="@yield('meta_description', 'Spend less. Buy more. Curated household utilities and premium gift items in Nigeria.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/og-banner.jpg'))">

    <!-- Google Fonts: Outfit (Geometric modern sans matching brand curves) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite build + CDN configuration for seamless local/Vercel support) -->
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        brand: {
                            maroon: '#520118',
                            maroonDark: '#3B0011',
                            maroonLight: '#700C25',
                            rose: '#C8024D',
                            roseDark: '#AB0242',
                            amber: '#FE9A02',
                            amberDark: '#E08200',
                            green: '#1E6115',
                            greenLight: '#28841C',
                            cream: '#FAF7F2',
                            creamSoft: '#FDFBF7',
                            creamBorder: '#F0E8DF',
                        }
                    },
                    boxShadow: {
                        'brand': '0 4px 20px -2px rgba(82, 1, 24, 0.07), 0 2px 6px -1px rgba(82, 1, 24, 0.04)',
                        'brand-hover': '0 12px 30px -4px rgba(82, 1, 24, 0.14), 0 4px 10px -2px rgba(82, 1, 24, 0.06)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #FAF7F2; color: #1F2937; }
        .bg-maroon { background-color: #520118; }
        .text-maroon { color: #520118; }
        .border-maroon { border-color: #520118; }
        .hover-bg-maroon:hover { background-color: #3B0011; }
        
        .bg-brand-rose { background-color: #C8024D; }
        .text-brand-rose { color: #C8024D; }
        .border-brand-rose { border-color: #C8024D; }
        .hover-bg-brand-rose:hover { background-color: #AB0242; }

        .bg-brand-amber { background-color: #FE9A02; }
        .text-brand-amber { color: #FE9A02; }
        
        .bg-brand-green { background-color: #1E6115; }
        .text-brand-green { color: #1E6115; }
        .hover-bg-brand-green:hover { background-color: #154C10; }

        .bg-cream { background-color: #FAF7F2; }
        .bg-cream-soft { background-color: #FDFBF7; }
        .border-cream { border-color: #F0E8DF; }

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .tap-highlight-transparent { -webkit-tap-highlight-color: transparent; }
    </style>

    <!-- Schema.org JSON-LD Structured Data for Google Rich Results -->
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '/#website',
                'url' => url('/'),
                'name' => 'Karakopo',
                'description' => 'Spend less. Buy more. Curated household utilities and premium gift items in Nigeria.',
                'publisher' => ['@id' => url('/') . '/#organization'],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => route('shop') . '?search={search_term_string}'
                    ],
                    'query-input' => 'required name=search_term_string'
                ]
            ],
            [
                '@type' => 'Store',
                '@id' => url('/') . '/#organization',
                'name' => 'Karakopo',
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                    'caption' => 'Karakopo Logo'
                ],
                'image' => asset('images/og-banner.jpg'),
                'description' => 'Smart retail and curated home utilities store in Nigeria.',
                'telephone' => '+2348126215642',
                'email' => 'hello@karakopo.com',
                'priceRange' => '₦₦',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressCountry' => 'NG',
                    'addressRegion' => 'Lagos'
                ]
            ]
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @yield('schema_extra')
</head>
<body class="bg-brand-cream text-gray-800 flex flex-col min-h-screen antialiased selection:bg-brand-rose selection:text-white">
    
    <!-- Top Announcement & Perks Bar -->
    <aside aria-label="Announcement" class="bg-brand-maroonDark text-white text-[11px] sm:text-xs py-1.5 px-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2 truncate">
                <span class="bg-brand-amber text-brand-maroon text-[9px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider hidden sm:inline-block">Special Offer</span>
                <span class="truncate">✨ Spend less. Buy more! Quality kitchen utilities & souvenirs across Nigeria.</span>
            </div>
            <div class="flex items-center space-x-4 flex-shrink-0 text-white/90">
                <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20I%20would%20like%20to%20inquire%20about%20your%20products" target="_blank" rel="noopener noreferrer" class="hover:text-brand-amber transition-colors flex items-center">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 mr-1.5 animate-pulse"></span>
                    WhatsApp Orders: <strong class="ml-1 text-white">08126215642</strong>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Navigation Header -->
    <header class="bg-white border-b border-brand-creamBorder sticky top-0 z-50 shadow-sm backdrop-blur-md bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-4">
                
                <!-- Brand Logo Lockup -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center group focus:outline-none" aria-label="Karakopo Home">
                        <img src="{{ asset('images/logo-horizontal.png') }}" 
                             onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" 
                             alt="Karakopo — Spend less. Buy more." 
                             class="h-9 sm:h-11 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.02]">
                    </a>
                </div>

                <!-- Desktop Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-4 lg:mx-8">
                    <form action="{{ route('shop') }}" method="GET" class="w-full relative">
                        <input type="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search kitchenware, decor, souvenirs..." 
                               class="w-full pl-10 pr-24 py-2 text-sm bg-brand-creamSoft border border-brand-creamBorder rounded-full focus:outline-none focus:border-brand-maroon focus:ring-1 focus:ring-brand-maroon transition-all">
                        <span class="absolute left-3.5 top-2.5 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <button type="submit" class="absolute right-1.5 top-1 bottom-1 px-3.5 bg-brand-maroon hover-bg-maroon text-white text-xs font-bold rounded-full transition-colors flex items-center">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-7">
                    <a href="{{ route('home') }}" class="text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'text-brand-maroon border-b-2 border-brand-maroon pb-0.5' : 'text-gray-600 hover:text-brand-maroon' }}">
                        Home
                    </a>
                    <a href="{{ route('shop') }}" class="text-sm font-semibold transition-colors {{ request()->routeIs('shop*') ? 'text-brand-maroon border-b-2 border-brand-maroon pb-0.5' : 'text-gray-600 hover:text-brand-maroon' }}">
                        Shop Catalog
                    </a>
                    <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20I%20want%20to%20order%20directly" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-brand-green hover:text-brand-greenLight flex items-center gap-1 transition-colors">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                        WhatsApp Desk
                    </a>
                </nav>

                <!-- Right Actions: Admin Link, Cart Badge, Mobile Toggle -->
                <div class="flex items-center space-x-2.5 sm:space-x-4">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-brand-maroon hover-bg-maroon text-white shadow-sm transition-all">
                                <span class="w-2 h-2 rounded-full bg-brand-amber mr-1.5"></span>
                                Admin OS
                            </a>
                        @endif
                    @endauth

                    <!-- Cart Button with Pill Badge -->
                    @php
                        $cartItems = (array) session('cart');
                        $cartCount = array_sum(array_column($cartItems, 'quantity'));
                    @endphp
                    <a href="{{ route('cart.index') }}" 
                       class="relative inline-flex items-center p-2 rounded-xl text-gray-700 hover:text-brand-maroon hover:bg-brand-creamSoft transition-all tap-highlight-transparent" 
                       aria-label="Shopping Cart ({{ $cartCount }} items)">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span id="cart-badge" class="absolute -top-1 -right-1 bg-brand-rose text-white text-[11px] font-black rounded-full h-5 min-w-[20px] px-1 flex items-center justify-center shadow-md {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                    </a>

                    <!-- Mobile Menu Hamburger Button -->
                    <button id="mobile-menu-button" type="button" class="lg:hidden p-2 rounded-xl text-gray-700 hover:text-brand-maroon hover:bg-brand-creamSoft focus:outline-none tap-highlight-transparent" aria-label="Toggle navigation menu">
                        <svg id="hamburger-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Search Bar (Directly below header on small screens) -->
            <div class="md:hidden pb-3">
                <form action="{{ route('shop') }}" method="GET" class="relative">
                    <input type="search" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search household items, kitchen, gifts..." 
                           class="w-full pl-9 pr-20 py-2 text-xs bg-brand-creamSoft border border-brand-creamBorder rounded-full focus:outline-none focus:border-brand-maroon">
                    <span class="absolute left-3 top-2.5 text-gray-400 pointer-events-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <button type="submit" class="absolute right-1 top-1 bottom-1 px-3 bg-brand-maroon text-white text-[11px] font-bold rounded-full">
                        Find
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-brand-creamBorder bg-white px-4 pt-3 pb-6 space-y-2.5 shadow-xl">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('home') ? 'bg-brand-cream text-brand-maroon' : 'text-gray-700 hover:bg-gray-50' }}">
                <span>🏠</span>
                <span>Home</span>
            </a>
            <a href="{{ route('shop') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('shop*') ? 'bg-brand-cream text-brand-maroon' : 'text-gray-700 hover:bg-gray-50' }}">
                <span>🛍️</span>
                <span>Shop All Products</span>
            </a>
            <a href="{{ route('cart.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50">
                <span class="flex items-center space-x-3">
                    <span>🛒</span>
                    <span>Shopping Cart</span>
                </span>
                <span class="bg-brand-rose text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
            </a>
            <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20I%20would%20like%20to%20order" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-bold text-brand-green bg-green-50 hover:bg-green-100">
                <span>💬</span>
                <span>Order via WhatsApp (08126215642)</span>
            </a>

            <div class="pt-3 border-t border-gray-100">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold bg-brand-maroon text-white mb-2 shadow">
                            <span>👑 Admin Dashboard</span>
                            <span class="text-xs bg-white/20 px-2 py-0.5 rounded">OS</span>
                        </a>
                    @endif
                    <div class="flex items-center justify-between px-3.5 py-2 text-xs text-gray-500">
                        <span>Signed in as <strong>{{ auth()->user()->name }}</strong></span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-brand-rose hover:underline font-bold">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block text-center px-4 py-2.5 rounded-xl text-xs font-bold border border-brand-maroon text-brand-maroon hover:bg-brand-maroon hover:text-white transition-colors">
                        🔐 Merchant / Admin Sign In
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Flow -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border-l-4 border-brand-green text-green-900 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-brand-green flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="text-xs sm:text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-rose-50 border-l-4 border-brand-rose text-rose-900 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-brand-rose flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <span class="text-xs sm:text-sm font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Standard Multi-Column Footer -->
    <footer class="bg-brand-maroon text-white mt-16 border-t border-brand-maroonDark relative overflow-hidden">
        <!-- Subtle brand petal accent in background -->
        <div class="absolute -right-24 -bottom-24 w-96 h-96 bg-brand-rose/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-24 -top-24 w-96 h-96 bg-brand-amber/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12 relative z-10">
            <!-- 4 Column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- Column 1: Brand Info & Identity (2 cols wide on LG) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-white rounded-xl flex items-center justify-center p-1 shadow-md">
                            <img src="{{ asset('images/logo-icon.png') }}" alt="Karakopo Logo" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight leading-none block">Karakopo</span>
                            <span class="text-xs text-brand-amber font-serif italic">Spend less. Buy more.</span>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-white/80 leading-relaxed max-w-sm">
                        Nigeria's curated destination for functional household utilities, durable kitchen essentials, and tasteful souvenirs at fair, family-friendly prices.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-2 text-xs">
                        <span class="inline-flex items-center bg-white/10 px-2.5 py-1 rounded-full text-white/90">
                            🚚 Nationwide Delivery
                        </span>
                        <span class="inline-flex items-center bg-white/10 px-2.5 py-1 rounded-full text-white/90">
                            🛡️ 100% Quality Guaranteed
                        </span>
                        <span class="inline-flex items-center bg-white/10 px-2.5 py-1 rounded-full text-white/90">
                            💬 Instant WhatsApp Orders
                        </span>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-brand-amber mb-4 pb-1 border-b border-white/15">
                        Quick Navigation
                    </h3>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-white/80">
                        <li><a href="{{ route('home') }}" class="hover:text-white hover:underline transition-colors flex items-center">🏠 Home</a></li>
                        <li><a href="{{ route('shop') }}" class="hover:text-white hover:underline transition-colors flex items-center">🛍️ All Products</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white hover:underline transition-colors flex items-center">🛒 Shopping Cart</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white hover:underline transition-colors flex items-center">🔐 Admin Login</a></li>
                    </ul>
                </div>

                <!-- Column 3: Popular Categories -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-brand-amber mb-4 pb-1 border-b border-white/15">
                        Categories
                    </h3>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-white/80">
                        <li><a href="{{ route('shop', ['category' => 'kitchen-essentials']) }}" class="hover:text-white hover:underline transition-colors">🍳 Kitchen Essentials</a></li>
                        <li><a href="{{ route('shop', ['category' => 'tableware-dining']) }}" class="hover:text-white hover:underline transition-colors">🍽️ Tableware & Dining</a></li>
                        <li><a href="{{ route('shop', ['category' => 'home-decor']) }}" class="hover:text-white hover:underline transition-colors">🏺 Home Decor</a></li>
                        <li><a href="{{ route('shop', ['category' => 'gifts-souvenirs']) }}" class="hover:text-white hover:underline transition-colors">🎁 Gifts & Souvenirs</a></li>
                        <li><a href="{{ route('shop', ['category' => 'bathroom-organization']) }}" class="hover:text-white hover:underline transition-colors">🧺 Storage & Organization</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact & Direct Support -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-brand-amber mb-4 pb-1 border-b border-white/15">
                        Order & Inquiries
                    </h3>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-white/80">
                        <li>📞 Call: <a href="tel:08126215642" class="text-white font-bold hover:underline">08126215642</a></li>
                        <li>📧 Email: <a href="mailto:hello@karakopo.com" class="text-white hover:underline">hello@karakopo.com</a></li>
                        <li>📍 Location: Lagos, Nigeria (Nationwide Shipping)</li>
                        <li class="pt-2">
                            <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20I%20have%20an%20inquiry" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3.5 py-2 rounded-xl bg-brand-green hover:bg-brand-greenLight text-white text-xs font-bold shadow transition-all">
                                <svg class="w-4 h-4 mr-1.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                                Chat on WhatsApp
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Legal & Copyright -->
            <div class="mt-12 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/70">
                <div>
                    &copy; {{ date('Y') }} <strong>Karakopo</strong>. Spend less. Buy more. All rights reserved.
                </div>
                <div class="flex items-center space-x-4">
                    <span>🏦 Bank Transfer: OPay (8135631609)</span>
                    <span>•</span>
                    <a href="{{ route('shop') }}" class="hover:underline">Catalog</a>
                    <span>•</span>
                    <a href="https://wa.me/2348126215642" class="hover:underline">Help Desk</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col space-y-2 pointer-events-none"></div>

    <script>
        // Mobile Hamburger Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                const isOpen = !mobileMenu.classList.contains('hidden');
                if (isOpen) {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                } else {
                    mobileMenu.classList.remove('hidden');
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                }
            });
        }

        // Global Toast Notification Helper
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            const bgClass = type === 'error' ? 'bg-brand-rose' : 'bg-brand-maroonDark';
            toast.className = `${bgClass} text-white text-xs sm:text-sm font-semibold px-4 py-3 rounded-xl shadow-2xl flex items-center space-x-2 transform transition-all duration-300 opacity-0 translate-y-3 pointer-events-auto border border-white/15`;
            
            toast.innerHTML = `
                <span>${message}</span>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-3');
                toast.classList.add('opacity-100', 'translate-y-0');
            });

            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'translate-y-3');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };
    </script>
    @stack('scripts')
</body>
</html>
