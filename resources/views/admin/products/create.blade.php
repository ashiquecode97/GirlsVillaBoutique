@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-xl rounded-xl p-6 hover-lift transition-all">

    <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">
        Create New Product
    </h1>

    <form method="POST" action="{{ route('admin.products.store') }}" 
          enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Product Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded-lg px-4 py-2.5 bg-gray-50 focus:bg-white
                   focus:ring-2 focus:ring-indigo-400 outline-none transition">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Price, Stock, Active --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (₹)</label>
                <input type="number" name="price" value="{{ old('price') }}"
                       class="w-full border rounded-lg px-4 py-2.5 bg-gray-50 focus:bg-white
                       focus:ring-2 focus:ring-indigo-400 outline-none transition">
                @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                <input type="number" name="stock" value="{{ old('stock') }}"
                       class="w-full border rounded-lg px-4 py-2.5 bg-gray-50 focus:bg-white
                       focus:ring-2 focus:ring-indigo-400 outline-none transition">
                @error('stock') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2 pt-6">
                <label class="block mt-3">
                    <span class="text-gray-700 font-medium">Status</span>
                    <select name="is_active" class="w-full px-3 py-2 border rounded">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </label>

            </div>

        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded-lg px-4 py-2.5 bg-gray-50 focus:bg-white
                      focus:ring-2 focus:ring-indigo-400 outline-none transition">{{ old('description') }}</textarea>
            @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Image --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
            <input type="file" name="image"
                   class="w-full border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 
                   focus:ring-indigo-400 outline-none transition">
            @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Submit Button --}}
        <div class="pt-4">
            <button class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2.5
                bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-500
                text-white rounded-lg text-sm font-semibold tracking-wide
                shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                💾 Save Product
            </button>
        </div>

    </form>
</div>
@endsection
