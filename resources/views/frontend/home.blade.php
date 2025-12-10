@extends('layouts.app')

@section('content')

{{-- 🔥 HERO OFFER SECTION --}}
<div class="relative rounded-xl overflow-hidden mb-8 shadow-lg">
    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff"
         class="w-full h-64 object-cover">
    
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-center text-white px-4">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-2 drop-shadow-lg">
            Big Winter Sale ❄️
        </h1>
        <p class="text-lg md:text-xl font-medium mb-4">
            Up to 50% OFF on Electronics & Accessories
        </p>
        <a href="#products"
           class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-pink-500
                  text-white rounded-lg font-semibold shadow-lg hover:scale-105 
                  transition duration-300">
            Shop Now
        </a>
    </div>
</div>

{{-- 🛒 PRODUCTS SECTION --}}
<h2 id="products" class="text-xl md:text-2xl font-bold mb-4">Featured Products</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

    @foreach($products as $product)
        <div class="bg-white rounded-xl shadow hover:shadow-xl hover-lift 
                    transition duration-300 p-4 border border-gray-100">

            {{-- Product Image --}}
            <div class="relative">
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="w-full h-48 object-cover rounded-lg">
                
                {{-- SALE TAG --}}
                <span class="absolute top-2 left-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full shadow">
                    SALE
                </span>
            </div>

            {{-- Product Info --}}
            <h3 class="text-lg font-semibold mt-3">{{ $product->name }}</h3>
            <p class="text-gray-600 text-sm">{{ Str::limit($product->description, 50) }}</p>
                        {{-- Show Sizes --}}
            @if($product->size)
                <div class="mt-2">
                    <span class="text-xs text-gray-500 font-semibold">Sizes:</span>

                    @foreach(explode(',', $product->size) as $size)
                        <span class="inline-block px-2 py-0.5 bg-gray-100 
                                    border border-gray-300 rounded-md text-xs text-gray-700 mr-1 mt-1">
                            {{ $size }}
                        </span>
                    @endforeach
                </div>
            @endif
            <div class="flex justify-between items-center mt-4">
                <span class="text-lg font-bold text-green-600">
                    ₹{{ number_format($product->price) }}
                </span>

                <a href="{{ route('products.show', $product) }}"
                   class="px-3 py-1.5 bg-blue-600 text-white rounded-lg 
                          hover:bg-blue-700 text-sm transition">
                    View
                </a>
            </div>
        </div>
    @endforeach

</div>

@endsection
