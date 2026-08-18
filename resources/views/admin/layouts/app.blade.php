<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karakopo Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#FFF6E9] text-gray-800 font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:flex-row">
        <!-- Sidebar -->
        <aside class="w-full sm:w-64 bg-[#5B1032] text-white flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold tracking-wider">K<span class="text-xs uppercase ml-1 opacity-75">Admin</span></h1>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-[#7a1543] {{ request()->routeIs('admin.dashboard') ? 'bg-[#7a1543]' : '' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-6 py-3 hover:bg-[#7a1543] {{ request()->routeIs('admin.products.*') ? 'bg-[#7a1543]' : '' }}">Products</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-6 py-3 hover:bg-[#7a1543] {{ request()->routeIs('admin.categories.*') ? 'bg-[#7a1543]' : '' }}">Categories</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                <div>
                    <span class="text-sm text-gray-600">Admin User</span>
                </div>
            </header>

            <div class="p-6 flex-1 overflow-y-auto">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul class="list-disc pl-5">
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
</body>
</html>
