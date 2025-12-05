@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">🛒 Your Shopping Cart</h1>

@if($items->isEmpty())

    <div class="bg-white p-6 rounded-xl shadow text-center">
        <p class="text-gray-600 text-lg">Your cart is empty.</p>
        <a href="{{ route('products.index') }}"
           class="mt-3 inline-block px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Browse Products
        </a>
    </div>

@else

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- LEFT: CART ITEMS -->
    <div class="lg:col-span-2 space-y-4">

        @foreach($items as $item)
        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition border flex items-center gap-4">

            <!-- Product Image -->
            <img src="{{ asset('storage/'.$item->product->image) }}"
                 class="w-24 h-24 object-cover rounded-lg border">

            <!-- Product Info -->
            <div class="flex-1">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $item->product->name }}
                </h2>
                <p class="text-sm text-gray-500">
                    {{ Str::limit($item->product->description, 60) }}
                </p>

                <div class="mt-2 text-green-600 font-bold">
                    ₹{{ number_format($item->product->price) }}
                </div>
            </div>

            <!-- Quantity Update -->
            {{-- <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2"> --}}
                @csrf
                @method('PUT')

                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                       class="w-16 border rounded px-2 py-1 text-center">

                <button class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                    Update
                </button>
            </form>

            <!-- Subtotal -->
            <div class="font-bold text-gray-800 w-24 text-right">
                ₹{{ number_format($item->product->price * $item->quantity) }}
            </div>

            <!-- Remove -->
            <form method="POST" action="{{ route('cart.remove', $item) }}">
                @csrf
                @method('DELETE')

                <button class="p-2 rounded-full bg-red-600 text-white hover:bg-red-700">
                    ✖
                </button>
            </form>

        </div>
        @endforeach

    </div>

    <!-- RIGHT: ORDER SUMMARY -->
    <div>
        <div class="bg-white p-6 rounded-xl shadow-md border">

            <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>

            <div class="flex justify-between text-gray-700 mb-2">
                <span>Subtotal</span>
                <span>₹{{ number_format($total) }}</span>
            </div>

            <div class="flex justify-between text-gray-700 mb-2">
                <span>Shipping</span>
                <span class="text-green-600 font-semibold">FREE</span>
            </div>

            <hr class="my-3">

            <div class="flex justify-between text-xl font-bold text-gray-800">
                <span>Total</span>
                <span>₹{{ number_format($total) }}</span>
            </div>

            <!-- Checkout Button -->
            <a href="{{ route('checkout.index') }}"
               class="mt-5 block text-center px-5 py-3 bg-gradient-to-r from-pink-500 to-purple-600
                      text-white rounded-xl font-semibold hover:scale-[1.02] transition">
                Proceed to Checkout
            </a>

        </div>
    </div>

</div>

@endif

@endsection
