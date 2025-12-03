@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Products</h1>
            <p class="text-sm text-gray-500">Manage all products in your catalog.</p>
        </div>

        {{-- CREATE BUTTON --}}
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
            + Add New Product
        </a>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-green-50 text-green-800 border border-green-200 rounded-md text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table wrapper --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase">
                    <tr>
                        <th class="px-4 py-3 w-12">ID</th>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right w-48">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-700">
                                {{ $product->id }}
                            </td>

                            <td class="px-4 py-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}"
                                         class="w-10 h-10 object-cover rounded-md border border-gray-200">
                                @else
                                    <span class="text-xs text-gray-400">No image</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800">
                                    {{ $product->name }}
                                </div>
                                @if($product->description)
                                    <div class="text-xs text-gray-500">
                                        {{ Str::limit($product->description, 40) }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-gray-800">
                                ₹{{ $product->price }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $product->stock }}
                            </td>

                            <td class="px-4 py-3">
                                @if($product->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    {{-- EDIT BUTTON --}}
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-md text-xs font-medium hover:bg-indigo-700">
                                        Edit
                                    </a>

                                    {{-- DELETE BUTTON --}}
                                    <form action="{{ route('admin.products.destroy', $product) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md text-xs font-medium hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500 text-sm">
                                No products found. Click “Add New Product” to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
            {{ $products->links() }}
        </div>
    </div>
@endsection
