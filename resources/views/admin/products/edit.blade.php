@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
    <h1 class="text-xl font-bold mb-4">Edit Product</h1>

    <form method="POST" action="{{ route('admin.products.update', $product) }}"
          enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Price</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            <div class="flex items-center gap-2">
                <label class="block mt-3">
                        <span class="text-gray-700 font-medium">Status</span>
                        <select name="is_active" class="w-full px-3 py-2 border rounded">
                            <option value="1" {{ $product->is_active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Inactive</option>
                        </select>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <div>
                <label class="block text-sm font-medium mb-1">Current Image</label>
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="w-32 h-32 object-cover rounded">
                @else
                    <p class="text-xs text-gray-500">No image uploaded.</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Change Image</label>
                <input type="file" name="image"
                       class="w-full border rounded px-3 py-2 bg-white">
            </div>
        </div>

        <div class="pt-2">
            <button class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update Product
            </button>
        </div>
    </form>
@endsection
