@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
    <h1 class="text-xl font-bold mb-4">Create Product</h1>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Price</label>
                <input type="number" name="price" value="{{ old('price') }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Stock</label>
                <input type="number" name="stock" value="{{ old('stock') }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('stock') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" checked
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="text-sm text-gray-700">Active</span>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
            @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image</label>
            <input type="file" name="image"
                   class="w-full border rounded px-3 py-2 bg-white">
            @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save Product
            </button>
        </div>
    </form>
@endsection
