@extends('admin.layouts.app')

@section('title', 'Edit Product: ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Edit Product Listing</h3>
            <p class="text-xs sm:text-sm text-gray-500">Update product details, pricing, photos, and inventory</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-sm font-bold text-maroon hover:underline flex items-center">
            &larr; Back to Products
        </a>
    </div>

    <!-- Promotional Caption Quick Bar on Edit Page -->
    @php
        $publicUrl = route('product.show', $product->slug);
        $effectivePrice = $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price;
        $wasPriceStr = $product->sale_price && $product->sale_price < $product->price ? " (was ₦" . number_format($product->price) . ")" : "";
        $promoCaption = "✨ *" . $product->name . "* ✨\n"
                      . ($product->short_description ? $product->short_description . "\n\n" : "")
                      . "💰 *Price:* ₦" . number_format($effectivePrice) . $wasPriceStr . "\n"
                      . "📦 Stock: " . $product->stock . " units\n"
                      . "🚚 Doorstep delivery across Nigeria!\n\n"
                      . "🛒 *Order here:* " . $publicUrl . "\n\n"
                      . "*Karakopo* — Spend less. Buy more. 🛍️";
    @endphp
    <div class="bg-gradient-to-r from-[#5B1032] to-[#7a1543] text-white p-5 rounded-2xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-[10px] uppercase font-bold tracking-wider bg-white/20 px-2 py-0.5 rounded-full">Social Commerce</span>
            <h4 class="font-bold text-sm mt-1">Marketing Caption Ready for Sharing</h4>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button type="button" onclick="navigator.clipboard.writeText(`{{ addslashes($promoCaption) }}`); window.showToast('Promotional copy copied!');" class="px-3 py-1.5 bg-white text-maroon font-bold text-xs rounded-lg hover:bg-gray-100 shadow transition-colors">
                📋 Copy Promo Caption
            </button>
            <a href="https://wa.me/?text={{ urlencode($promoCaption) }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white font-bold text-xs rounded-lg shadow transition-colors">
                Post to WhatsApp
            </a>
            <a href="{{ $publicUrl }}" target="_blank" class="px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white font-semibold text-xs rounded-lg transition-colors">
                View Public Page ↗
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon bg-white" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Available Stock <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Regular Price (₦) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                </div>

                <!-- Sale Price -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Sale Price (₦) <span class="text-xs text-gray-400 font-normal">Optional Discount</span>
                    </label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon">
                </div>

                <!-- Existing Images Display -->
                @if($product->images->count() > 0)
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                        Current Product Photos
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->images as $image)
                            <div class="relative w-24 h-24 rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover">
                                @if($image->is_primary)
                                    <span class="absolute bottom-1 left-1 bg-black/70 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">Primary</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Add More Images -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Add More Photos
                    </label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full text-sm border border-gray-300 rounded-xl py-2 px-3 bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-maroon file:text-white hover:file:bg-[#7a1543]">
                </div>

                <!-- Short Description -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Short Hook / One-Liner
                    </label>
                    <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon">
                </div>

                <!-- Detailed Description -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Full Product Details & Specifications
                    </label>
                    <textarea name="description" rows="5" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Toggles -->
                <div class="sm:col-span-2 flex items-center space-x-6 pt-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-maroon focus:ring-maroon h-4 w-4" {{ $product->is_published ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-semibold text-gray-800">Published to Storefront</span>
                    </label>

                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-maroon focus:ring-maroon h-4 w-4" {{ $product->is_featured ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-semibold text-gray-800">Featured on Homepage</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="pt-6 border-t border-gray-100 flex items-center space-x-3">
                <button type="submit" class="px-6 py-3 bg-maroon text-white font-bold text-sm rounded-xl hover-bg-maroon transition-all shadow-md">
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-5 py-3 text-sm font-semibold text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
