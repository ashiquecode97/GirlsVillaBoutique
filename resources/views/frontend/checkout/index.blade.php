@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">Checkout</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- LEFT: ADDRESS + PAYMENT FORM -->
    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md border">

        <form method="POST" action="{{ route('checkout.placeOrder') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label class="text-gray-700 font-medium">Full Name</label>
                <input type="text" name="name" class="w-full border rounded-lg px-3 py-2 mt-1" required>
            </div>

            <!-- Address -->
            <div>
                <label class="text-gray-700 font-medium">Delivery Address</label>
                <textarea name="address" class="w-full border rounded-lg px-3 py-2 mt-1" rows="3" required></textarea>
            </div>

            <!-- City + Pincode -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-700 font-medium">City</label>
                    <input type="text" name="city" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                </div>
                <div>
                    <label class="text-gray-700 font-medium">Pincode</label>
                    <input type="text" name="pincode" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                </div>
            </div>

            <!-- Phone -->
            <div>
                <label class="text-gray-700 font-medium">Phone Number</label>
                <input type="text" name="phone" class="w-full border rounded-lg px-3 py-2 mt-1" required>
            </div>

            <!-- Payment -->
            <h3 class="text-xl font-semibold text-gray-800 mt-6">Payment Method</h3>

            <div class="space-y-3 mt-2">

                <label class="flex items-center gap-3 border rounded-lg p-3 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="payment_method" value="cod" required>
                    <span class="text-gray-700 font-medium">Cash on Delivery</span>
                </label>

                <label class="flex items-center gap-3 border rounded-lg p-3 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="payment_method" value="online" required>
                    <span class="text-gray-700 font-medium">UPI / Online Payment</span>
                </label>
            </div>

            <button
                class="mt-5 w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold text-lg transition">
                Confirm Order
            </button>
        </form>

    </div>

    <!-- RIGHT: ORDER SUMMARY -->
    <div class="bg-white p-6 rounded-xl shadow-md border">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>

        @foreach($cartItems as $item)
            <div class="flex justify-between mb-2 text-gray-700">
                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                <span>₹{{ number_format($item->quantity * $item->product->price) }}</span>
            </div>
        @endforeach

        <hr class="my-3">

        <div class="flex justify-between text-lg font-bold text-gray-800">
            <span>Total</span>
            <span>₹{{ number_format($total) }}</span>
        </div>
    </div>

</div>

@endsection
