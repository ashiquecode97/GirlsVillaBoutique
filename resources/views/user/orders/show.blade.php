@extends('layouts.app')

@section('content')
{{-- @dd($order->items) --}}


<div class="max-w-4xl mx-auto py-8 px-4">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Order Details — #{{ $order->id }}
        </h1>

        <div class="flex gap-3">
            <a href="{{ route('admin.orders.invoice', $order) }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">
               📄 Download Invoice
            </a>

            <button onclick="window.print()"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md shadow hover:bg-gray-300">
                🖨 Print
            </button>
        </div>
    </div>

    {{-- ORDER STATUS BOX --}}
    <div class="p-4 rounded-lg border bg-indigo-50 mb-6">
        <p class="text-sm text-gray-600">Order Status</p>
        <p class="text-lg font-bold text-indigo-700">{{ ucfirst($order->status) }}</p>
    </div>

    {{-- ORDER META --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Information</h2>

        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
        <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
        <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount) }}</p>
    </div>

    {{-- ITEMS --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Items in this Order</h2>

        <div class="space-y-4">
            @foreach($order->items as $item)
            <div class="flex gap-4 p-4 border rounded-lg bg-gray-50">
                <img src="{{ asset('storage/' . $item->product->image) }}"
                     class="w-24 h-24 rounded-md object-cover">

                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $item->product->name }}</h3>

                    <p class="text-sm text-gray-600">Size: <strong>{{ $item->size }}</strong></p>
                    <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>

                    <p class="text-md font-bold text-indigo-700 mt-2">
                        ₹{{ number_format($item->price * $item->quantity) }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
