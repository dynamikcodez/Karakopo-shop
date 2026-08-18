@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ $category->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5B1032] focus:ring-[#5B1032] p-2 border" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5B1032] focus:ring-[#5B1032] p-2 border">{{ $category->description }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Image</label>
            @if($category->image)
                <div class="mb-2"><img src="{{ asset('storage/' . $category->image) }}" class="h-20 w-20 object-cover rounded"></div>
            @endif
            <input type="file" name="image" class="mt-1 block w-full">
        </div>
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-[#5B1032] shadow-sm focus:border-[#5B1032] focus:ring focus:ring-[#5B1032] focus:ring-opacity-50" {{ $category->is_published ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-600">Published</span>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-[#5B1032] text-white px-4 py-2 rounded shadow hover:bg-[#7a1543]">Update Category</button>
            <a href="{{ route('admin.categories.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</div>
@endsection
