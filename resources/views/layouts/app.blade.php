<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Karakopo | Smart Abundance')</title>
    <meta name="description" content="Spend less. Buy more. Curated household utilities and premium gift items in Nigeria.">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Outfit', sans-serif; }
        .bg-cream { background-color: #FFF6E9; }
        .text-maroon { color: #5B1032; }
        .bg-maroon { background-color: #5B1032; }
        .hover-bg-maroon:hover { background-color: #7a1543; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-cream text-gray-800 flex flex-col min-h-screen">
    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-maroon tracking-tight">Karakopo.</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-maroon font-medium">Home</a>
                    <a href="{{ route('shop') }}" class="text-gray-600 hover:text-maroon font-medium">Shop</a>
                </nav>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-maroon relative">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-maroon text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ count((array) session('cart')) }}</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-maroon text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Karakopo</h3>
                    <p class="text-sm opacity-80">Smart Abundance.<br>Spend less. Buy more.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm opacity-80">
                        <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                        <li><a href="{{ route('shop') }}" class="hover:underline">Shop</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-sm opacity-80">
                        <li>Email: hello@karakopo.com</li>
                        <li>Location: Nigeria</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-white/20 text-center text-sm opacity-60">
                &copy; {{ date('Y') }} Karakopo. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
