@extends('layouts.app')

@section('content')
<h1>All Products</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

    @foreach($products as $product)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="w-full h-40 object-cover rounded-md mb-3">

            <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
            <p class="text-gray-600 text-sm">{{ Str::limit($product->description, 50) }}</p>

            <div class="flex justify-between items-center mt-3">
                <span class="text-lg font-bold text-green-600">₹{{ $product->price }}</span>

                <a href="{{ route('products.show', $product) }}"
                   class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    View
                </a>
            </div>
        </div>
    @endforeach

</div>


{{ $products->links() }}
@endsection
