@extends('admin.layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Create Product Listing</h3>
            <p class="text-xs sm:text-sm text-gray-500">Add an item to your store with high-res photos and descriptions</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-sm font-bold text-maroon hover:underline flex items-center">
            &larr; Back to Products
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Premium Ceramic Dining Set (16 Pieces)" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon bg-white" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    <input type="number" name="stock" value="{{ old('stock', 10) }}" min="0" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                </div>

                <!-- Regular Price -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Regular Price (₦) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="25000" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                </div>

                <!-- Sale Price -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Sale Price (₦) <span class="text-xs text-gray-400 font-normal">Optional Discount</span>
                    </label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="Leave blank if no discount" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon">
                </div>

                <!-- Image Upload -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Product Photos (Upload multiple)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-maroon transition-colors bg-gray-50">
                        <div class="space-y-2 text-center">
                            <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-transparent rounded-md font-bold text-maroon hover:underline">
                                    <span>Upload picture files</span>
                                    <input id="file-upload" name="images[]" type="file" multiple accept="image/*" class="sr-only" onchange="previewImages(event)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 2MB each</p>
                        </div>
                    </div>
                    <!-- Preview Container -->
                    <div id="image-preview" class="grid grid-cols-4 sm:grid-cols-6 gap-3 mt-4 hidden"></div>
                </div>

                <!-- Short Description -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Short Hook / One-Liner
                    </label>
                    <input type="text" name="short_description" value="{{ old('short_description') }}" placeholder="Brief catchy summary used in WhatsApp captions & card previews" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon">
                </div>

                <!-- Detailed Description -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        Full Product Details & Specifications
                    </label>
                    <textarea name="description" rows="5" placeholder="Detailed product information, materials, dimensions, and Nigerian home care instructions..." class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon">{{ old('description') }}</textarea>
                </div>

                <!-- Toggles -->
                <div class="sm:col-span-2 flex items-center space-x-6 pt-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-maroon focus:ring-maroon h-4 w-4" checked>
                        <span class="ml-2 text-sm font-semibold text-gray-800">Publish to Storefront immediately</span>
                    </label>

                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-maroon focus:ring-maroon h-4 w-4">
                        <span class="ml-2 text-sm font-semibold text-gray-800">Feature on Homepage</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="pt-6 border-t border-gray-100 flex items-center space-x-3">
                <button type="submit" class="px-6 py-3 bg-maroon text-white font-bold text-sm rounded-xl hover-bg-maroon transition-all shadow-md">
                    Publish Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-5 py-3 text-sm font-semibold text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImages(event) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        const files = event.target.files;

        if (files.length > 0) {
            preview.classList.remove('hidden');
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'aspect-square rounded-xl overflow-hidden border border-gray-200 shadow-sm';
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            preview.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
