@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Page header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">My Orders</h1>
            {{-- <p class="mt-1 text-sm text-gray-500">Recent purchases and order statuses — stylish and clear.</p> --}}
        </div>

        <div class="flex items-center gap-3">
            <img src="{{ asset('storage/logo.jpg') }}" alt="logo" class="w-12 h-12 rounded-md object-cover shadow-sm">
            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700">
                GirlsVilla Boutique
            </span>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white p-10 rounded-2xl shadow-lg text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" class="w-24 mx-auto mb-4">
            <h2 class="text-xl font-semibold text-gray-700">No Orders Yet</h2>
            <p class="text-gray-500 mt-2">Looks like you haven’t placed any orders.</p>
            <a href="{{ route('products.index') }}"
               class="mt-6 inline-block px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow hover:scale-[1.02] transition">
                Shop Now
            </a>
        </div>
    @else
        <div class="space-y-6">
             <div class="mb-6 rounded-xl border border-indigo-100 bg-indigo-50 p-4 text-sm text-indigo-800">
                    ⏱ <strong>Cancellation Policy:</strong>
                    Orders can be cancelled within <strong>24 hours</strong> and only when status is
                    <strong>Pending</strong> or <strong>Processing</strong>.
                </div>
            @foreach($orders as $order)
                    @php
                        // card / badge classes mapped to statuses
                        $cardMap = [
                            'Pending' => ['bg'=>'bg-yellow-50','border'=>'border-yellow-200','ring'=>'ring-yellow-50'],
                            'Processing' => ['bg'=>'bg-sky-50','border'=>'border-sky-200','ring'=>'ring-sky-50'],
                            'Success' => ['bg'=>'bg-emerald-50','border'=>'border-emerald-200','ring'=>'ring-emerald-50'],
                            'Cancelled' => ['bg'=>'bg-rose-50','border'=>'border-rose-200','ring'=>'ring-rose-50'],
                        ];
                        $badgeMap = [
                            'Pending' => 'bg-yellow-200 text-yellow-800',
                            'Processing' => 'bg-sky-200 text-sky-800',
                            'Success' => 'bg-emerald-200 text-emerald-800',
                            'Cancelled' => 'bg-rose-200 text-rose-800',
                        ];
                        $card = $cardMap[$order->status] ?? ['bg'=>'bg-gray-50','border'=>'border-gray-200','ring'=>'ring-gray-50'];
                        $badge = $badgeMap[$order->status] ?? 'bg-gray-200 text-gray-800';
                    @endphp
                <article class="relative rounded-2xl border {{ $card['border'] }} {{ $card['bg'] }} shadow-sm transition hover:shadow-md">

                    {{-- Header --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 border-b">
                        <div>
                            <a href="{{ route('user.orders.show', $order) }}"
                            class="text-lg font-semibold text-indigo-700 hover:underline">
                                Order #{{ $order->id }}
                            </a>
                            <p class="text-sm text-gray-500">
                                Placed on {{ $order->created_at->format('d M Y, h:i A') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $badge }}">
                                {{ ucfirst($order->status) }}
                            </span>

                            <a href="{{ route('admin.orders.invoice', $order) ?? '#' }}"
                            class="px-3 py-1 text-xs rounded-md bg-white border text-indigo-600 hover:bg-indigo-50">
                                📄 Invoice
                            </a>

                            <button onclick="window.print()"
                                class="px-3 py-1 text-xs rounded-md bg-white border text-gray-700 hover:bg-gray-100">
                                🖨 Print
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-5">

                        {{-- ITEMS --}}
                        <div class="lg:col-span-2 space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 rounded-xl bg-white p-4 border">
                                    <img src="{{ asset('storage/'.$item->product->image) }}"
                                        class="w-20 h-24 object-cover rounded-lg">

                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Size: <strong>{{ $item->size ?? '-' }}</strong> |
                                            Qty: <strong>{{ $item->quantity }}</strong>
                                        </p>
                                        <p class="mt-2 font-semibold text-indigo-700">
                                            ₹{{ number_format($item->price * $item->quantity) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- SUMMARY --}}
                        <aside class="rounded-xl bg-gradient-to-b from-white to-indigo-50 p-5 border">
                            <div class="text-sm text-gray-500">Payment</div>
                            <div class="font-semibold text-gray-800 mt-1">
                                {{ strtoupper($order->payment_method ?? 'COD') }}
                            </div>

                            <div class="mt-4 text-sm text-gray-500">Grand Total</div>
                            <div class="text-2xl font-extrabold text-indigo-700">
                                ₹{{ number_format($order->total_amount) }}
                            </div>

                            {{-- CANCEL BUTTON --}}
                            @if(in_array($order->status, ['Pending', 'Processing']))

                                {{-- ⏱ Allowed within 24 hours --}}
                                @if($order->created_at->diffInHours(now()) <= 24)

                                    <form action="{{ route('user.orders.cancel', $order) }}"
                                        method="POST"
                                        class="mt-4"
                                        onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                        @csrf
                                        <button
                                            class="w-full py-2 rounded-lg bg-rose-600 text-white font-semibold
                                                hover:bg-rose-700 transition">
                                            ❌ Cancel Order
                                        </button>
                                    </form>

                                {{-- ⛔ Expired --}}
                                @else
                                    <span class="mt-3 inline-block text-xs text-gray-500 italic">
                                        ⏱ Cancellation window expired (24 hours passed)
                                    </span>
                                @endif

                            @endif

                        </aside>

                    </div>
                </article>

              
            @endforeach
        </div>
    @endif

</div>
@endsection
