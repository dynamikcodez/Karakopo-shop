@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h3 class="text-lg font-semibold">Manage Products</h3>
    <a href="{{ route('admin.products.create') }}" class="bg-[#5B1032] text-white px-4 py-2 rounded shadow hover:bg-[#7a1543]">+ Add Product</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price / Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($products as $product)
            <tr>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                    <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $product->category ? $product->category->name : 'None' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ₦{{ number_format($product->price, 2) }}
                    <div class="text-xs {{ $product->stock <= 5 ? 'text-red-500 font-bold' : 'text-gray-500' }}">Stock: {{ $product->stock }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($product->is_published)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-[#5B1032] hover:text-[#7a1543] mr-3">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-3 border-t">
        {{ $products->links() }}
    </div>
</div>
@endsection
