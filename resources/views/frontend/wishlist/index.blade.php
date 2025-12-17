@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-8">❤️ My Wishlist</h1>

    @if($wishlists->isEmpty())
        <div class="bg-white p-10 rounded-xl shadow text-center">
            <p class="text-gray-600 text-lg">Your wishlist is empty.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg">
                Browse Products
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $item)
                <div class="bg-white rounded-xl shadow hover:shadow-xl transition">

                    <img src="{{ asset('storage/'.$item->product->image) }}"
                         class="w-full h-52 object-cover rounded-t-xl">

                    <div class="p-4 space-y-2">
                        <h3 class="font-semibold text-gray-800">
                            {{ $item->product->name }}
                        </h3>

                        <p class="text-green-600 font-bold">
                            ₹{{ number_format($item->product->price) }}
                        </p>

                        <div class="flex items-center justify-between pt-2">
                            <a href="{{ route('products.show', $item->product) }}"
                               class="text-indigo-600 text-sm font-semibold">
                                View
                            </a>

                            <form action="{{ route('wishlist.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 text-sm">
                                    ✕ Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
