@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
        🧾 Order #{{ $order->id }}
    </h1>

    <a href="{{ route('admin.orders.invoice', $order) }}"
        class="px-5 py-3 bg-gradient-to-r from-green-500 to-green-700 
               text-white font-semibold rounded-xl shadow-md
               hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
        🧾 Download Invoice
    </a>
</div>

<!-- SUCCESS MESSAGE -->
@if(session('success'))
<div class="mb-6 px-5 py-3 bg-green-100 text-green-800 border border-green-300 rounded-xl shadow-sm">
    ✅ {{ session('success') }}
</div>
@endif

<!-- MAIN CARD -->
<div class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300">

    <!-- TIMELINE -->
    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Order Timeline</h2>

    @php
        $steps = ['pending' => 1, 'processing' => 2, 'success' => 3, 'cancelled' => -1];
        $current = $steps[$order->status] ?? 0;

        $timeline = [
            ['id' => 1, 'label' => 'Pending', 'color' => 'blue'],
            ['id' => 2, 'label' => 'Processing', 'color' => 'yellow'],
            ['id' => 3, 'label' => 'Completed', 'color' => 'green'],
        ];
    @endphp

    <div class="relative flex items-center justify-between my-10">

        <!-- LINE -->
        <div class="absolute left-0 top-1/2 w-full h-1 bg-gray-200 -z-10"></div>

        @foreach ($timeline as $step)
            <div class="flex flex-col items-center text-center w-1/3">
                <div class="w-14 h-14 flex items-center justify-center rounded-full shadow-lg 
                    text-white text-lg font-semibold transition transform-gpu
                    {{ $current >= $step['id'] ? 'bg-'.$step['color'].'-600' : 'bg-gray-300 text-gray-600' }}">
                    {{ $step['id'] }}
                </div>
                <span class="mt-3 text-sm font-medium tracking-wide
                    {{ $current >= $step['id'] ? 'text-'.$step['color'].'-600' : 'text-gray-500' }}">
                    {{ $step['label'] }}
                </span>
            </div>
        @endforeach
    </div>

    <!-- CANCELLED ALERT -->
    @if($order->status === 'cancelled')
        <div class="mt-6 p-5 bg-red-100 text-red-700 border border-red-300 rounded-xl text-center font-semibold shadow-sm">
            ❌ This order has been <strong>Cancelled</strong>.
        </div>
    @endif

    <!-- CUSTOMER INFORMATION -->
    <h2 class="text-2xl font-semibold text-gray-900 mt-12 mb-4">Customer Information</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-xl shadow-inner">
        <p><strong class="text-gray-800">Name:</strong> {{ $order->name }}</p>
        <p><strong class="text-gray-800">Email:</strong> {{ $order->email }}</p>
        <p><strong class="text-gray-800">Phone:</strong> {{ $order->phone }}</p>
        <p>
            <strong class="text-gray-800">Address:</strong> 
            {{ $order->address }}, {{ $order->city }} - {{ $order->pincode }}
        </p>
    </div>

    <!-- ORDER ITEMS -->
    <h2 class="text-2xl font-semibold text-gray-900 mt-12 mb-4">Order Items</h2>

    <table class="w-full bg-white rounded-xl shadow-lg overflow-hidden border">
        <thead class="bg-gray-100 text-gray-700 uppercase text-sm font-semibold">
            <tr>
                <th class="p-4 text-left">Product</th>
                <th class="p-4 text-left">Quantity</th>
                {{-- <th class="p-4 text-left">Size</th> --}}
                <th class="p-4 text-left">Price</th>
                <th class="p-4 text-left">Total</th>
            </tr>
        </thead>

       <tbody class="text-gray-700 divide-y">
    @foreach($order->items as $item)
    <tr class="hover:bg-gray-50 transition">

        <!-- PRODUCT NAME + SIZE -->
        <td class="p-4 font-medium text-gray-800">
            {{ $item->product->name }}

            @if($item->size)
                <span class="ml-2 px-2 py-1 bg-gray-100 rounded text-sm text-gray-600">
                    Size: {{ $item->size }}
                </span>
            @endif
        </td>

        <td class="p-4">{{ $item->quantity }}</td>

        <td class="p-4">₹{{ number_format($item->price) }}</td>

        <td class="p-4 font-semibold">
            ₹{{ number_format($item->price * $item->quantity) }}
        </td>

    </tr>
    @endforeach
</tbody>



    </table>

    <div class="mt-6 text-xl font-bold text-gray-900">
        Total Amount: <span class="text-green-600">₹{{ number_format($order->total_amount) }}</span>
    </div>

    <!-- STATUS UPDATE -->
    <h2 class="text-2xl font-semibold text-gray-900 mt-12 mb-4">Update Order Status</h2>

    <form action="{{ route('admin.orders.update', $order) }}" method="POST"
          class="bg-gray-50 p-6 rounded-xl shadow-inner space-y-4">
        @csrf
        @method('PUT')

        <label class="block font-medium text-gray-700">
            Status
            <select name="status"
                class="mt-2 w-full border p-3 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 transition">
                <option value="pending"    {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="success"    {{ $order->status == 'success' ? 'selected' : '' }}>Success</option>
                <option value="cancelled"  {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </label>

        <button
            class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-700
                   text-white rounded-xl shadow-md hover:shadow-xl 
                   hover:-translate-y-1 transition transform-gpu duration-200">
            Update Status
        </button>
    </form>

</div>

@endsection
