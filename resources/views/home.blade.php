@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left pt-12">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Smart Abundance.</span>
                        <span class="block text-maroon">Spend less. Buy more.</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Curated household utilities and premium gift items tailored for Nigerian homes. Find quality, functionality, and elegance all in one place.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('shop') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-maroon hover-bg-maroon md:py-4 md:text-lg transition-colors">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-cream flex items-center justify-center">
        <!-- Placeholder for beautiful hero image -->
        <div class="w-full h-64 sm:h-72 md:h-96 lg:h-full bg-gradient-to-br from-[#FFF6E9] to-[#f5e3cc] flex items-center justify-center">
            <span class="text-maroon opacity-50 text-2xl font-bold">Karakopo Home Essentials</span>
        </div>
    </div>
</div>

<!-- Featured Categories -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-gray-900 text-center mb-10">Shop by Category</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="group block relative rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow bg-white aspect-[4/3]">
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                    <span class="text-gray-400">No Image</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-end p-4">
                <h3 class="text-white font-bold text-lg drop-shadow-md">{{ $category->name }}</h3>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- Featured Products -->
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-3xl font-bold text-gray-900">Featured Products</h2>
            <a href="{{ route('shop') }}" class="text-maroon font-medium hover:underline hidden sm:block">View all &rarr;</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</div>

<!-- Promotional Section -->
<div class="bg-maroon text-white py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl font-bold mb-4">Premium Quality. Accessible Prices.</h2>
        <p class="max-w-2xl mx-auto text-lg opacity-90 mb-8">Upgrade your household with items that last. Karakopo handpicks every utility to ensure you get the absolute best value.</p>
        <a href="{{ route('shop') }}" class="inline-block bg-white text-maroon font-bold px-8 py-3 rounded shadow hover:bg-gray-100 transition-colors">Explore Collection</a>
    </div>
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-2xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl"></div>
</div>

<!-- Popular Products -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-gray-900 mb-10">Popular Right Now</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
        @foreach($popularProducts as $product)
            @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>
</div>
@endsection
