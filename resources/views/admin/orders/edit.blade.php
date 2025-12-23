@extends('admin.layouts.app')

@section('title', 'Update Order Status')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">

    <h2 class="text-xl font-bold mb-4 text-gray-800">Order #{{ $order->id }}</h2>

    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Order Status</label>

            <select name="status"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition">
                <option value="pending"    {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'success' ? 'selected' : '' }}>Success</option>
                <option value="success"    {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled"  {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <button class="w-full py-2 bg-gradient-to-r from-indigo-600 to-purple-600 
                       text-white rounded-lg shadow-md hover:shadow-xl hover:scale-105 
                       transition-all duration-300 font-semibold">
            Update Status
        </button>

    </form>
</div>

@endsection
