@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h3 class="text-lg font-semibold">Manage Categories</h3>
    <a href="{{ route('admin.categories.create') }}" class="bg-[#5B1032] text-white px-4 py-2 rounded shadow hover:bg-[#7a1543]">+ Add Category</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($categories as $category)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="font-medium text-gray-900">{{ $category->name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($category->is_published)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Draft</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-[#5B1032] hover:text-[#7a1543] mr-3">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-3 border-t">
        {{ $categories->links() }}
    </div>
</div>
@endsection
