@extends('layouts.app')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <img src="{{ asset('storage/'.$product->image) }}"
         class="w-full rounded-lg shadow">

    <div>
        <h1 class="text-3xl font-bold mb-3">{{ $product->name }}</h1>

        <p class="text-gray-600 mb-4">{{ $product->description }}</p>

        <p class="text-2xl font-semibold text-green-600 mb-6">Only ₹{{ $product->price }}/-</p>

        @auth
        <form action="{{ route('cart.add', $product) }}" method="POST">
            @csrf
            <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Add to Cart
            </button>
        </form>
        @else
            <p class="text-sm text-gray-700">
                <a href="{{ route('login') }}" class="text-blue-600 underline">Login</a>
                to add this product to your cart.
            </p>
        @endauth
    </div>

</div>

@endsection
