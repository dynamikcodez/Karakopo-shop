<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Karakopo Control Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-maroon { background-color: #5B1032; }
        .text-maroon { color: #5B1032; }
        .border-maroon { border-color: #5B1032; }
        .hover-bg-maroon:hover { background-color: #7a1543; }
        .bg-cream { background-color: #FFF6E9; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-gray-800 antialiased flex flex-col min-h-screen">
    <div class="flex-1 flex flex-col md:flex-row min-h-screen">
        <!-- Mobile Header Bar -->
        <div class="md:hidden bg-maroon text-white px-4 py-3 flex items-center justify-between shadow sticky top-0 z-40">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto bg-white rounded-full p-0.5">
                <span class="font-extrabold text-lg tracking-tight">Karakopo <span class="text-xs font-normal opacity-80 uppercase bg-white/20 px-1.5 py-0.5 rounded">Admin</span></span>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('home') }}" class="text-xs bg-white/20 hover:bg-white/30 text-white px-2.5 py-1.5 rounded-lg transition-colors" title="View Store">
                    🏪 Store
                </a>
                <button id="admin-sidebar-toggle" type="button" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white focus:outline-none" aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <!-- Sidebar (Desktop Fixed + Mobile Off-Canvas Drawer) -->
        <aside id="admin-sidebar" class="hidden md:flex flex-col w-full md:w-64 bg-maroon text-white flex-shrink-0 z-30 transition-all duration-300">
            <!-- Brand Logo -->
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto bg-white rounded-full p-1 shadow">
                    <div>
                        <h1 class="text-xl font-black tracking-tight leading-none">Karakopo</h1>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-white/70">Merchant OS</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-white/20 text-white shadow' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Products
                    </div>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 text-white shadow' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Categories
                </a>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-white/20 text-white shadow' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Customer Orders
                    </div>
                    @php
                        $pendingCount = \App\Models\Order::where('order_status', 'Pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="bg-yellow-400 text-maroon text-[11px] font-black px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>

                <div class="pt-4 mt-4 border-t border-white/10 space-y-1.5">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center px-4 py-2.5 rounded-xl text-xs font-semibold text-white/80 hover:bg-white/10 hover:text-white transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        View Public Storefront ↗
                    </a>
                </div>
            </nav>

            <!-- Bottom User & Logout -->
            <div class="p-4 border-t border-white/10 bg-black/10">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 pr-2">
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-[11px] text-white/60 truncate">{{ auth()->user()->email ?? 'admin@karakopo.com' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-colors" title="Sign Out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 overflow-x-hidden">
            <!-- Desktop Topbar -->
            <header class="hidden md:flex bg-white border-b border-gray-200 px-6 sm:px-8 py-4 justify-between items-center sticky top-0 z-20">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">@yield('title')</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center text-xs font-semibold px-3 py-1.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        View Store
                    </a>
                    <div class="flex items-center space-x-2 pl-4 border-l border-gray-200">
                        <div class="w-8 h-8 rounded-full bg-cream text-maroon font-bold flex items-center justify-center text-xs">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="text-xs font-semibold text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <div class="p-4 sm:p-6 lg:p-8 flex-1">
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r shadow-sm flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r shadow-sm flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r shadow-sm">
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Toast Notification Container for Admin -->
    <div id="admin-toast" class="fixed bottom-5 right-5 z-50 flex flex-col space-y-2 pointer-events-none"></div>

    <script>
        // Mobile Sidebar Toggle
        const sidebarToggle = document.getElementById('admin-sidebar-toggle');
        const adminSidebar = document.getElementById('admin-sidebar');

        if (sidebarToggle && adminSidebar) {
            sidebarToggle.addEventListener('click', () => {
                adminSidebar.classList.toggle('hidden');
            });
        }

        // Global Toast Notification Helper for Admin
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('admin-toast');
            if (!container) return;

            const toast = document.createElement('div');
            const bgClass = type === 'error' ? 'bg-red-600' : 'bg-gray-900';
            toast.className = `${bgClass} text-white text-xs sm:text-sm font-medium px-4 py-3 rounded-xl shadow-xl flex items-center space-x-2 transform transition-all duration-300 opacity-0 translate-y-3 pointer-events-auto`;
            
            toast.innerHTML = `<span>${message}</span>`;
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
