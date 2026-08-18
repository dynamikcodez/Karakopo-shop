@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" value="{{ $product->name }}" class="mt-1 block w-full rounded-md border p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" class="mt-1 block w-full rounded-md border p-2" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Price (₦)</label>
                <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="mt-1 block w-full rounded-md border p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sale Price (₦)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ $product->sale_price }}" class="mt-1 block w-full rounded-md border p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="mt-1 block w-full rounded-md border p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Add Images</label>
                <input type="file" name="images[]" multiple class="mt-1 block w-full p-2">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Short Description</label>
            <textarea name="short_description" rows="2" class="mt-1 block w-full rounded-md border p-2">{{ $product->short_description }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Detailed Description</label>
            <textarea name="description" rows="5" class="mt-1 block w-full rounded-md border p-2">{{ $product->description }}</textarea>
        </div>

        @if($product->images->count() > 0)
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
            <div class="flex gap-4 overflow-x-auto">
                @foreach($product->images as $image)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="h-24 w-24 object-cover rounded shadow">
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex gap-4 mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-[#5B1032]" {{ $product->is_published ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">Published</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-[#5B1032]" {{ $product->is_featured ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">Featured</span>
            </label>
        </div>

        <div>
            <button type="submit" class="bg-[#5B1032] text-white px-4 py-2 rounded shadow hover:bg-[#7a1543]">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</div>
@endsection
