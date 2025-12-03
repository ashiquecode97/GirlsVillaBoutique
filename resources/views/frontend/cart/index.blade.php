@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Your Cart</h1>

@if($items->isEmpty())

    <p class="text-gray-600">Your cart is empty.</p>

@else

<table class="w-full border-collapse bg-white shadow rounded-lg overflow-hidden">
    <thead class="bg-gray-200 text-left">
        <tr>
            <th class="p-3">Product</th>
            <th class="p-3">Price</th>
            <th class="p-3">Qty</th>
            <th class="p-3">Subtotal</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($items as $item)
            <tr class="border-t">
                <td class="p-3">{{ $item->product->name }}</td>
                <td class="p-3">₹{{ $item->product->price }}</td>
                <td class="p-3">{{ $item->quantity }}</td>
                <td class="p-3">₹{{ $item->quantity * $item->product->price }}</td>
                <td class="p-3">

                    <form method="POST" action="{{ route('cart.remove', $item) }}">
                        @csrf
                        @method('DELETE')

                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                            Remove
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<p class="text-xl font-bold mt-6">Total: ₹{{ $total }}</p>

@endif

@endsection
