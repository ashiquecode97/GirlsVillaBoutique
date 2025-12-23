@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">Checkout</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6"
     x-data="{ payment: '' }">

    <!-- LEFT -->
    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md border">

        <form method="POST" action="{{ route('checkout.placeOrder') }}" class="space-y-5">
            @csrf

            {{-- BUY NOW HIDDEN FIELDS --}}
            @if(request('buy_now'))
                <input type="hidden" name="buy_now" value="1">
                <input type="hidden" name="product_id" value="{{ $cartItems[0]->product->id }}">
                <input type="hidden" name="qty" value="{{ $cartItems[0]->quantity }}">
                <input type="hidden" name="size" value="{{ $cartItems[0]->size }}">
            @endif

            {{-- NAME --}}
            <div>
                <label class="font-medium text-gray-700">Full Name</label>
                <input name="name" class="w-full border rounded-lg p-2 mt-1" required>
            </div>

            {{-- EMAIL --}}
            {{-- <div>
                <label class="font-medium text-gray-700">Email( Order details sent to this email.)</label>
                <input name="email" class="w-full border rounded-lg p-2 mt-1" required>
            </div> --}}

            {{-- ADDRESS --}}
            <div>
                <label class="font-medium text-gray-700">Delivery Address</label>
                <textarea name="address" rows="3"
                          class="w-full border rounded-lg p-2 mt-1" required></textarea>
            </div>

            {{-- CITY & PIN --}}
            <div class="grid grid-cols-2 gap-4">
                <input name="city" placeholder="City"
                       class="border p-2 rounded-lg" required>
                <input name="pincode" placeholder="Pincode"
                       class="border p-2 rounded-lg" required>
            </div>

            {{-- PHONE --}}
            <input name="phone" placeholder="Phone"
                   class="w-full border p-2 rounded-lg" required>

            {{-- PAYMENT --}}
            <h3 class="text-xl font-semibold text-gray-800">Payment Method</h3>

            <label class="flex gap-3 border p-3 rounded-lg cursor-pointer">
                <input type="radio" name="payment_method" value="cod"
                       x-model="payment" required>
                Cash on Delivery
            </label>

            <label class="flex gap-3 border p-3 rounded-lg cursor-pointer">
                <input type="radio" name="payment_method" value="online"
                       x-model="payment" required>
                UPI / Online Payment
            </label>

            {{-- UPI DETAILS --}}
            <div x-show="payment === 'online'" x-cloak
                 class="bg-gray-50 p-4 rounded-xl space-y-3">

                <img src="{{ asset('storage/upi-qr.jpeg') }}"
                     class="w-40 mx-auto rounded-lg">

                <div class="flex gap-2">
                    <input readonly value="7002233886@ybl"
                           class="w-full bg-gray-100 p-2 rounded">
                    <button type="button"
                        onclick="navigator.clipboard.writeText('7002233886@ybl')"
                        class="px-3 bg-indigo-600 text-white rounded">
                        Copy
                    </button>
                </div>
            </div>

            <button
                class="w-full bg-green-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-green-700">
                Confirm Order
            </button>
        </form>
    </div>

    <!-- RIGHT -->
    <div class="bg-white p-6 rounded-xl shadow-md border">
        <h2 class="text-xl font-bold mb-4">Order Summary</h2>

        @foreach($cartItems as $item)
            <div class="flex justify-between text-sm mb-2">
                <span>
                    {{ $item->product->name }} × {{ $item->quantity }}
                </span>
                <span>
                    ₹{{ number_format($item->product->price * $item->quantity) }}
                </span>
            </div>
        @endforeach

        <hr class="my-3">

        <div class="flex justify-between font-bold text-lg">
            <span>Total</span>
            <span>₹{{ number_format($total) }}</span>
        </div>
    </div>

</div>

@endsection
