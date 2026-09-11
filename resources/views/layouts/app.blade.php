<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'Karakopo | Spend less. Buy more.')</title>
    <meta name="description" content="@yield('meta_description', 'Spend less. Buy more. Curated household utilities and premium gift items in Nigeria.')">
    
    <!-- Open Graph / WhatsApp / Telegram sharing meta tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Karakopo | Spend less. Buy more.')">
    <meta property="og:description" content="@yield('meta_description', 'Spend less. Buy more. Curated household utilities and premium gift items in Nigeria.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Outfit', sans-serif; }
        .bg-cream { background-color: #FFF6E9; }
        .text-maroon { color: #5B1032; }
        .bg-maroon { background-color: #5B1032; }
        .border-maroon { border-color: #5B1032; }
        .hover-bg-maroon:hover { background-color: #7a1543; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .tap-highlight-transparent { -webkit-tap-highlight-color: transparent; }
    </style>
</head>
<body class="bg-cream text-gray-800 flex flex-col min-h-screen antialiased">
    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Brand Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2.5">
                        <img src="{{ asset('images/logo.png') }}" alt="Karakopo Logo" class="h-9 sm:h-10 w-auto object-contain">
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl sm:text-2xl text-maroon tracking-tight leading-none">Karakopo</span>
                            <span class="text-[10px] text-gray-500 tracking-wider font-semibold uppercase hidden sm:block">Spend less. Buy more.</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-maroon font-medium transition-colors {{ request()->routeIs('home') ? 'text-maroon font-bold' : '' }}">Home</a>
                    <a href="{{ route('shop') }}" class="text-gray-700 hover:text-maroon font-medium transition-colors {{ request()->routeIs('shop*') ? 'text-maroon font-bold' : '' }}">Shop</a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-maroon text-white hover-bg-maroon transition-colors shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Admin Panel
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-maroon transition-colors">Admin Login</a>
                    @endauth
                </nav>

                <!-- Right Side: Cart + Mobile Hamburger -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <!-- Cart Button -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-maroon transition-colors tap-highlight-transparent" aria-label="Shopping Cart">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @php
                            $cartCount = count((array) session('cart'));
                        @endphp
                        <span id="cart-badge" class="absolute -top-1 -right-1 bg-maroon text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                    </a>

                    <!-- Mobile Menu Hamburger Button -->
                    <button id="mobile-menu-button" type="button" class="md:hidden p-2 rounded-lg text-gray-700 hover:text-maroon hover:bg-gray-100 focus:outline-none tap-highlight-transparent" aria-label="Toggle navigation menu">
                        <svg id="hamburger-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer / Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white px-4 pt-3 pb-6 space-y-3 shadow-lg transition-all">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('home') ? 'bg-cream text-maroon font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                🏠 Home
            </a>
            <a href="{{ route('shop') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('shop*') ? 'bg-cream text-maroon font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                🛍️ Shop Products
            </a>
            <a href="{{ route('cart.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">
                <span>🛒 Shopping Cart</span>
                <span class="bg-maroon text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
            </a>

            <div class="pt-3 border-t border-gray-100">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-base font-semibold bg-maroon text-white mb-2 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Admin Dashboard
                        </a>
                    @endif
                    <div class="flex items-center justify-between px-3 py-2 text-sm text-gray-600">
                        <span>Signed in as <strong>{{ auth()->user()->name }}</strong></span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:underline font-semibold">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block text-center px-4 py-2.5 rounded-lg text-sm font-semibold border border-maroon text-maroon hover:bg-maroon hover:text-white transition-colors">
                        Admin Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-maroon text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="h-9 w-9 bg-white rounded-full flex items-center justify-center p-1 shadow">
                            <img src="{{ asset('images/logo.png') }}" alt="Karakopo Logo" class="h-full w-full object-contain">
                        </div>
                        <h3 class="text-xl font-bold tracking-tight">Karakopo</h3>
                    </div>
                    <p class="text-sm opacity-85 leading-relaxed">
                        Spend less. Buy more.<br>
                        Curated household utilities, kitchen essentials, and premium souvenirs in Nigeria.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-white/20 pb-1">Quick Links</h3>
                    <ul class="space-y-2 text-sm opacity-85">
                        <li><a href="{{ route('home') }}" class="hover:underline flex items-center">🏠 Home</a></li>
                        <li><a href="{{ route('shop') }}" class="hover:underline flex items-center">🛍️ Shop Catalog</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:underline flex items-center">🛒 Cart</a></li>
                        <li><a href="{{ route('login') }}" class="hover:underline flex items-center">🔐 Admin Access</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-white/20 pb-1">Contact & Support</h3>
                    <ul class="space-y-2 text-sm opacity-85">
                        <li>📧 Email: <a href="mailto:hello@karakopo.com" class="hover:underline">hello@karakopo.com</a></li>
                        <li>📞 Phone: <a href="tel:08126215642" class="hover:underline font-semibold">08126215642</a></li>
                        <li>📍 Location: Nigeria</li>
                        <li class="pt-2">
                            <a href="https://wa.me/2348126215642?text=Hello%20Karakopo,%20I%20have%20an%20inquiry" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-1.5 rounded bg-green-600 hover:bg-green-700 text-white text-xs font-semibold shadow transition-colors">
                                <svg class="w-4 h-4 mr-1.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                                Chat on WhatsApp
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-white/15 text-center text-xs sm:text-sm opacity-70">
                &copy; {{ date('Y') }} Karakopo. All rights reserved. Built for Smart Nigerian Living.
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
            const bgClass = type === 'error' ? 'bg-red-600' : 'bg-gray-900';
            toast.className = `${bgClass} text-white text-sm font-medium px-4 py-3 rounded-lg shadow-xl flex items-center space-x-2 transform transition-all duration-300 opacity-0 translate-y-3 pointer-events-auto`;
            
            toast.innerHTML = `
                <span>${message}</span>
            `;

            container.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-3');
                toast.classList.add('opacity-100', 'translate-y-0');
            });

            // Remove after 3s
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
