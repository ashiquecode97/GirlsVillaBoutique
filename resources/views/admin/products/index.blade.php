@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Products</h1>
            <p class="text-sm text-gray-500 mt-1">Manage and control your full product inventory.</p>
        </div>

        {{-- CREATE BUTTON --}}
        <a href="{{ route('admin.products.create') }}"
            class="inline-flex items-center px-5 py-2.5 
                bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 
                text-white rounded-lg text-sm font-semibold
                shadow-md hover:shadow-xl transition-all duration-300 
                hover:-translate-y-1 hover:scale-[1.04]">
            + Add New Product
        </a>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 text-green-800 border border-green-200 rounded-md text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card Wrapper --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 font-semibold text-gray-600">SL</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Product Code</th>
                            <th class="px-5 py-3 font-semibold text-gray-600">Name</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Image</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Price</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Size</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Stock</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-5 py-3 font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $index => $product)
                        <tr class="hover:bg-gray-50 transition-colors">

                            {{-- SL NUMBER --}}
                            <td class="px-5 py-3 text-gray-700 font-medium">
                                {{ $products->firstItem() + $index }}
                            </td>

                            <td class="px-5 py-3 text-gray-700 font-medium">
                                {{ $product->product_code}}
                            </td>
                            {{-- <td class="px-5 py-3 text-gray-700 font-medium">
                                {{ $product->id }}
                            </td> --}}
                             <td class="px-5 py-3">
                                <div class="font-semibold text-gray-800">
                                    {{ $product->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ Str::limit($product->description, 40) }}
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}"
                                        class="w-12 h-12 object-cover rounded-md shadow-sm border border-gray-200">
                                @else
                                    <span class="text-xs text-gray-400">No image</span>
                                @endif
                            </td>

                           

                            <td class="px-5 py-3 text-gray-700 font-medium">
                                ₹{{ $product->price }}
                            </td>
                            <td class="px-5 py-3 text-gray-700">
                                @if($product->size)
                                    @foreach(explode(',', $product->size) as $size)
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs mr-1">
                                            {{ $size }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400 text-xs">No Size</span>
                                @endif
                            </td>


                            <td class="px-5 py-3 text-gray-700">
                                {{ $product->stock }}
                            </td>

                            <td class="px-5 py-3">
                                @if($product->is_active)
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-300">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-300">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-3 text-right">
                                <div class="inline-flex items-center gap-3">

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="px-4 py-1.5 bg-gradient-to-r from-blue-500 to-indigo-600 
                                        text-white rounded-md shadow hover:shadow-lg 
                                        hover:-translate-y-0.5 hover:scale-105 transition-all duration-300 text-xs font-semibold">
                                        Edit
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-4 py-1.5 bg-gradient-to-r from-red-500 to-red-700 
                                            text-white rounded-md shadow hover:shadow-lg 
                                            hover:-translate-y-0.5 hover:scale-105 transition-all duration-300 text-xs font-semibold">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-6 text-center text-gray-500 italic">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
            {{ $products->links() }}
        </div>

    </div>
@endsection
