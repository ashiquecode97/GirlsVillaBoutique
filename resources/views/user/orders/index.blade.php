@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Page header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">My Orders</h1>
            <p class="mt-1 text-sm text-gray-500">Recent purchases and order statuses — stylish and clear.</p>
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

                <article class="relative p-6 rounded-2xl border {{ $card['border'] }} {{ $card['bg'] }} shadow-sm hover:shadow-lg transition transform-gpu">
                    {{-- subtle top accent --}}
                    <div class="absolute -top-3 left-6 w-28 h-1 rounded-full bg-gradient-to-r from-indigo-400 to-pink-400 opacity-90"></div>

                    <div class="flex items-start justify-between gap-6">
                        {{-- left: order meta + items --}}
                        <div class="flex-1">
                            <div class="flex items-center justify-between gap-6">
                                <div>
                                    <a href="{{ route('user.orders.show', $order) }}"
                                        class="text-lg font-semibold text-indigo-700 hover:underline">
                                        Order #{{ $order->id }}
                                    </a>

                                    <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('d M Y') }}</p>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $badge }}">
                                        ● {{ ucfirst($order->status) }}
                                    </span>
                                    <a href="{{ route('admin.orders.invoice', $order) ?? '#' }}"
                                       class="text-xs inline-flex items-center gap-2 px-3 py-1 rounded-md border border-transparent hover:border-indigo-100 text-indigo-600">
                                        📄 Invoice
                                    </a>
                                    <button onclick="window.print()"
                                        class="text-xs inline-flex items-center gap-2 px-3 py-1 rounded-md border border-transparent bg-white hover:bg-indigo-50 text-indigo-700">
                                        🖨 Print
                                    </button>
                                </div>
                            </div>

                            {{-- items list --}}
                            <div class="mt-4 space-y-3">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-4 bg-white/40 rounded-lg p-3 border border-gray-100">
                                        <img src="{{ asset('storage/'.$item->product->image) }}" alt="" class="w-20 h-20 object-cover rounded-md">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="text-md font-semibold text-gray-800">{{ $item->product->name }}</div>
                                                    <div class="text-sm text-gray-500 mt-1">
                                                        <span class="mr-3">Size: <strong class="text-gray-700">{{ $item->size ?? '-' }}</strong></span>
                                                        <span>Qty: <strong class="text-gray-700">{{ $item->quantity }}</strong></span>
                                                    </div>
                                                </div>

                                                <div class="text-right">
                                                    <div class="text-sm text-gray-500">Unit</div>
                                                    <div class="text-lg font-bold text-indigo-700 mt-1">₹{{ number_format($item->price) }}</div>
                                                    <div class="text-sm text-gray-600 mt-1">₹{{ number_format($item->price * $item->quantity) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- right: order totals --}}
                        <aside class="w-60 shrink-0">
                            <div class="p-4 rounded-xl bg-gradient-to-b from-white to-indigo-50 border border-transparent shadow-sm">
                                <div class="text-sm text-gray-500">Subtotal</div>
                                @php $sub = $order->items->sum(fn($i) => $i->price * $i->quantity); @endphp
                                <div class="text-xl font-bold text-gray-900 mt-2">₹{{ number_format($sub) }}</div>

                                <div class="mt-4 text-sm text-gray-500 flex items-center justify-between">
                                    <span>Shipping</span><span class="text-green-600 font-semibold">FREE</span>
                                </div>

                                <div class="mt-4 border-t pt-3">
                                    <div class="text-sm text-gray-500">Payment</div>
                                    <div class="text-sm font-semibold text-gray-800 mt-1">{{ strtoupper($order->payment_method ?? 'COD') }}</div>
                                </div>

                                <div class="mt-4">
                                    <div class="text-xs text-gray-500">Grand Total</div>
                                    <div class="text-2xl font-extrabold text-indigo-700 mt-1">₹{{ number_format($order->total_amount) }}</div>
                                </div>
                            </div>
                        </aside>

                    </div>
                </article>
            @endforeach
        </div>
    @endif

</div>
@endsection
