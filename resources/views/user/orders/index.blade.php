@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">My Orders</h1>

<table class="w-full bg-white shadow rounded-lg overflow-hidden">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3">Order ID</th>
            <th class="p-3">Total</th>
            <th class="p-3">Status</th>
            <th class="p-3">Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orders as $order)
        <tr class="border-t">
            <td class="p-3">{{ $order->id }}</td>
            <td class="p-3">₹{{ number_format($order->total_amount) }}</td>
            <td class="p-3">
                <span class="px-3 py-1 rounded bg-blue-100 text-blue-600">
                    {{ $order->status }}
                </span>
            </td>
            <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
