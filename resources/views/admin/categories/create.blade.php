@extends('admin.layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5B1032] focus:ring-[#5B1032] p-2 border" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5B1032] focus:ring-[#5B1032] p-2 border"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="image" class="mt-1 block w-full">
        </div>
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-[#5B1032] shadow-sm focus:border-[#5B1032] focus:ring focus:ring-[#5B1032] focus:ring-opacity-50" checked>
            <span class="ml-2 text-sm text-gray-600">Published</span>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-[#5B1032] text-white px-4 py-2 rounded shadow hover:bg-[#7a1543]">Save Category</button>
            <a href="{{ route('admin.categories.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</div>
@endsection
