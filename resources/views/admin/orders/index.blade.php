@extends('admin.layouts.app')

@section('content')

<!-- PAGE HEADER -->
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
        <span class="text-indigo-600 text-4xl">📦</span> Orders Management
    </h1>

    <span class="px-4 py-2 text-sm bg-indigo-100 text-indigo-700 rounded-full shadow">
        Total Orders: {{ $orders->total() }}
    </span>
</div>


<!-- FILTER BAR -->
<div class="sticky top-0 bg-white/90 backdrop-blur-lg z-20 shadow-md rounded-xl mb-6 border border-gray-200">

    <form method="GET"
          class="flex flex-wrap items-center gap-4 p-4">

        <!-- Search -->
        <div class="relative w-72">
            <span class="absolute left-3 top-2.5 text-gray-400 text-lg">🔍</span>
            <input type="text" name="search" value="{{ request('search') }}"
                class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl w-full
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                       transition bg-gray-50 hover:bg-white shadow-sm"
                placeholder="Search by name, email, order ID...">
        </div>

        <!-- Status Dropdown -->
        <select name="status"
            class="px-4 py-2 border border-gray-300 rounded-xl bg-white cursor-pointer
                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                   transition shadow-sm">
            <option value="">All Status</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
            <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
        </select>

        <!-- Apply Button -->
        <button class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-medium shadow-md
                       hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-[2px]
                       transition duration-200">
            🚀 Apply
        </button>

        <!-- Reset Button -->
        <a href="{{ route('admin.orders.index') }}"
           class="px-6 py-2 bg-gray-200 text-gray-700 rounded-xl font-medium
                  hover:bg-gray-300 hover:shadow-md hover:-translate-y-[2px]
                  transition duration-200">
            ♻️ Reset
        </a>

    </form>
</div>


<!-- ORDER TABLE -->
<div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
    <table class="w-full text-left border-collapse">

        <!-- Header -->
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 uppercase text-xs tracking-wider">
            <tr>
                <th class="p-4">SL</th>
                <th class="p-4">Order ID</th>
                <th class="p-4">Customer</th>
                <th class="p-4">Total</th>
                <th class="p-4">Status</th>
                <th class="p-4">Date</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>

        <tbody class="text-gray-700">
            @foreach ($orders as $index => $order)
            <tr class="border-b hover:bg-gray-50 transition">

                <td class="p-4 text-gray-500">{{ $orders->firstItem() + $index }}</td>

                <td class="p-4 font-bold text-gray-900">#{{ $order->id }}</td>

                <td class="p-4">{{ $order->name }}</td>

                <td class="p-4 font-semibold text-gray-900">₹{{ number_format($order->total_amount) }}</td>

                <!-- Pro Status Badge -->
                <td class="p-4">
                    @php
                        $colors = [
                            'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'Processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                            'Delivered' => 'bg-green-100 text-green-800 border-green-300',
                        ];
                        $badge = $colors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                    @endphp

                    <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $badge }}">
                        ● {{ $order->status }}
                    </span>
                </td>

                <td class="p-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>

                <!-- ACTION BUTTONS -->
                <td class="p-4 text-center flex gap-2 justify-center">

                    <!-- View Button -->
                    <a href="{{ route('admin.orders.show', $order) }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md
                               hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-[2px]
                               transition">
                        👁 View
                    </a>

                    <!-- Delete Button -->
                    <form action="{{ route('admin.orders.destroy', $order) }}"
                        method="POST" class="inline-block"
                        onsubmit="return confirm('Delete this order permanently?')">

                        @csrf
                        @method('DELETE')

                        <button class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-md
                                       hover:bg-red-700 hover:shadow-lg hover:-translate-y-[2px]
                                       transition">
                            🗑 Delete
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- PAGINATION -->
@if ($orders->hasPages())
    <div class="mt-8 flex justify-center">
        <div class="flex items-center gap-2">

            @if ($orders->onFirstPage())
                <span class="px-3 py-2 bg-gray-200 rounded-lg text-gray-400">◀</span>
            @else
                <a href="{{ $orders->previousPageUrl() }}"
                   class="px-3 py-2 bg-white border rounded-lg shadow hover:bg-indigo-50">
                    ◀
                </a>
            @endif

            @foreach ($orders->links()->elements[0] as $page => $url)
                @if ($page == $orders->currentPage())
                    <span class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       class="px-4 py-2 bg-white border rounded-lg shadow hover:bg-indigo-50">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}"
                   class="px-3 py-2 bg-white border rounded-lg shadow hover:bg-indigo-50">
                    ▶
                </a>
            @else
                <span class="px-3 py-2 bg-gray-200 rounded-lg text-gray-400">▶</span>
            @endif

        </div>
    </div>
@endif


@endsection
