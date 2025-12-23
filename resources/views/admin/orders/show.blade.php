@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
        🧾 Order #{{ $order->id }}
    </h1>

    <a href="{{ route('admin.orders.invoice', $order) }}"
       class="px-5 py-3 bg-gradient-to-r from-green-500 to-green-700
              text-white font-semibold rounded-xl shadow-md
              hover:shadow-xl hover:-translate-y-1 transition">
        🧾 Download Invoice
    </a>
</div>

{{-- ================= FLASH MESSAGE ================= --}}
@if(session('success'))
    <div class="mb-6 px-5 py-3 bg-green-100 text-green-800 border border-green-300 rounded-xl shadow-sm">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- ================= MAIN CARD ================= --}}
<div class="bg-white p-8 rounded-2xl shadow-xl space-y-14">

{{-- ================= TIMELINE ================= --}}
@php
    $steps = [
        'pending'   => 1,
        'success'   => 2,
        'delivered' => 3,
        'cancelled' => -1,
    ];
    $current = $steps[$order->status] ?? 0;

    $timeline = [
        ['id' => 1, 'label' => 'Pending', 'color' => 'blue'],
        ['id' => 2, 'label' => 'Payment Success', 'color' => 'yellow'],
        ['id' => 3, 'label' => 'Delivered', 'color' => 'green'],
    ];
@endphp

<div>
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Order Timeline</h2>

    <div class="relative flex justify-between items-center">
        <div class="absolute left-0 top-1/2 w-full h-1 bg-gray-200 -z-10"></div>

        @foreach($timeline as $step)
            <div class="flex flex-col items-center w-1/3">
                <div class="w-14 h-14 rounded-full flex items-center justify-center
                    text-white font-bold shadow
                    {{ $current >= $step['id']
                        ? 'bg-'.$step['color'].'-600'
                        : 'bg-gray-300 text-gray-600' }}">
                    {{ $step['id'] }}
                </div>
                <span class="mt-3 text-sm font-medium
                    {{ $current >= $step['id']
                        ? 'text-'.$step['color'].'-600'
                        : 'text-gray-500' }}">
                    {{ $step['label'] }}
                </span>
            </div>
        @endforeach
    </div>

    @if($order->status === 'cancelled')
        <div class="mt-6 p-4 bg-red-100 text-red-700 rounded-xl font-semibold text-center">
            ❌ Order has been cancelled
        </div>
    @endif
</div>

{{-- ================= CUSTOMER INFO ================= --}}
<div>
    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Customer Information</h2>

    <div class="grid sm:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-xl shadow-inner">
        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Address:</strong>
            {{ $order->address }}, {{ $order->city }} - {{ $order->pincode }}
        </p>
    </div>
</div>

{{-- ================= PAYMENT INFO ================= --}}
<div>
    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Payment Details</h2>

    <div class="grid sm:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-xl shadow-inner">
        <p>
            <strong>Method:</strong>
            {{ strtoupper($order->payment_method) }}
        </p>

        <p>
            <strong>Verification:</strong>
            @if($order->payment_verified)
                <span class="text-green-600 font-semibold">Verified</span>
            @else
                <span class="text-red-600 font-semibold">Not Verified</span>
            @endif
        </p>
    </div>
</div>

{{-- ================= ORDER ITEMS ================= --}}
<div>
    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Order Items</h2>

    <table class="w-full rounded-xl overflow-hidden shadow border">
        <thead class="bg-gray-100 text-sm uppercase text-gray-700">
            <tr>
                <th class="p-4 text-left">Product</th>
                <th class="p-4 text-left">Qty</th>
                <th class="p-4 text-left">Price</th>
                <th class="p-4 text-left">Total</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @foreach($order->items as $item)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium flex items-center gap-3">
                        
                        <img src="{{ asset('storage/'.$item->product->image) }}"
                            class="w-12 h-12 object-cover rounded-md shadow-sm border border-gray-200">

                        <div>
                            <div>{{ $item->product->name }}</div>

                            @if($item->size)
                                <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                    Size {{ $item->size }}
                                </span>
                            @endif
                        </div>

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

    <div class="mt-4 text-xl font-bold">
        Total: <span class="text-green-600">₹{{ number_format($order->total_amount) }}</span>
    </div>
</div>

{{-- ================= UPDATE STATUS ================= --}}
<div>
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">
        Payment & Order Control
    </h2>

    <form action="{{ route('admin.orders.update', $order) }}"
          method="POST"
          class="bg-gray-50 p-6 rounded-xl shadow-inner grid md:grid-cols-2 gap-6">
        @csrf
        @method('PUT')

        {{-- Payment Verification --}}
        <div>
            <label class="font-medium block mb-2">Payment Verification</label>
            <select name="payment_verified"
                    class="w-full border p-3 rounded-xl">
                <option value="0" {{ !$order->payment_verified ? 'selected' : '' }}>
                    ❌ Not Verified
                </option>
                <option value="1" {{ $order->payment_verified ? 'selected' : '' }}>
                    ✅ Verified
                </option>
            </select>
        </div>

        {{-- Order Status --}}
        <div>
            <label class="font-medium block mb-2">Order Status</label>
            <select name="status"
                    class="w-full border p-3 rounded-xl">

                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="success" {{ $order->status === 'success' ? 'selected' : '' }}>
                    Payment Success
                </option>

                @if($order->payment_verified)
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>
                        Delivered
                    </option>
                @endif

                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>
            </select>

            @if(!$order->payment_verified)
                <p class="text-sm text-red-600 mt-2">
                    ⚠ Delivery disabled until payment is verified
                </p>
            @endif
        </div>

        <div class="md:col-span-2 flex justify-end">
            <button
                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700
                       text-white rounded-xl font-semibold shadow
                       hover:shadow-xl hover:-translate-y-0.5 transition">
                💾 Update Order
            </button>
        </div>
    </form>
</div>

</div>
@endsection
