@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">🛒 Your Shopping Cart</h1>

@if($items->isEmpty())

    <div class="bg-white p-6 rounded-xl shadow text-center">
        <p class="text-gray-600 text-lg">Your cart is empty.</p>
        <a href="{{ route('products.index') }}"
           class="mt-3 inline-block px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Browse Products
        </a>
    </div>

@else

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT: CART ITEMS --}}
    <div class="lg:col-span-2 space-y-4">

        @foreach($items as $item)
        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition border flex items-start gap-4">

            {{-- PRODUCT IMAGE --}}
            <img src="{{ asset('storage/'.$item->product->image) }}"
                 class="w-24 h-24 object-cover rounded-lg border">

            {{-- PRODUCT DETAILS --}}
            <div class="flex-1">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $item->product->name }}
                </h2>

                <p class="text-sm text-gray-500">
                    {{ Str::limit($item->product->description, 60) }}
                </p>

                {{-- SHOW SELECTED SIZE --}}
                <p class="text-sm text-gray-700 mt-1">
                    <strong>Size:</strong> {{ $item->size }}
                </p>

                {{-- PRICE --}}
                <div class="mt-3 text-green-600 font-bold">
                    ₹{{ number_format($item->product->price) }}
                </div>

                {{-- QUANTITY UI --}}
                <div class="mt-4">
                    <h4 class="text-sm font-semibold mb-1">Quantity</h4>

                    <div class="flex items-center gap-3">
                        <button type="button"
                                onclick="updateQty(-1, {{ $item->id }})"
                                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>

                        <span id="qtyDisplay_{{ $item->id }}" class="text-lg font-semibold">
                            {{ $item->quantity }}
                        </span>

                        <button type="button"
                                onclick="updateQty(1, {{ $item->id }})"
                                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                    </div>

                    <input type="hidden" id="quantity_{{ $item->id }}" value="{{ $item->quantity }}">
                    <input type="hidden" id="price_{{ $item->id }}" value="{{ $item->product->price }}">
                </div>
            </div>

            {{-- SUBTOTAL --}}
            <div class="font-bold text-gray-800 w-24 text-right" id="subtotal_{{ $item->id }}">
                ₹{{ number_format($item->product->price * $item->quantity) }}
            </div>

            {{-- REMOVE ITEM --}}
            <form method="POST" action="{{ route('cart.remove', $item) }}">
                @csrf
                @method('DELETE')
                <button class="p-2 rounded-full bg-red-600 text-white hover:bg-red-700">✖</button>
            </form>

        </div>
        @endforeach

    </div>

    {{-- RIGHT: ORDER SUMMARY --}}
  
    <div>
        <div class="bg-white p-6 rounded-xl shadow-md border">

            <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>

            {{-- SUBTOTAL --}}
            <div class="flex justify-between text-gray-700 mb-2">
                <span>Subtotal</span>
                <span id="summarySubtotal">₹{{ number_format($total) }}</span>
            </div>

            {{-- DISCOUNT FIELD --}}
            <div class="flex justify-between items-center text-gray-700 mb-2">
                <span>Discount</span>
                <input 
                    type="number" 
                    id="discountInput"
                    class="border rounded px-2 py-1 w-24 text-right"
                    value="0"
                    min="0"
                    oninput="updateSummary()">
            </div>

            {{-- SHIPPING --}}
            <div class="flex justify-between text-gray-700 mb-2">
                <span>Shipping</span>
                <span class="text-green-600 font-semibold">FREE</span>
            </div>

            <hr class="my-3">

            {{-- TOTAL --}}
            <div class="flex justify-between text-xl font-bold text-gray-800">
                <span>Total</span>
                <span id="summaryTotal">₹{{ number_format($total) }}</span>
            </div>

            <a href="{{ route('checkout.index') }}"
                class="mt-5 block text-center px-5 py-3 bg-gradient-to-r from-pink-500 to-purple-600
                        text-white rounded-xl font-semibold hover:scale-[1.02] transition">
                Proceed to Checkout
            </a>

        </div>
    </div>


</div>

@endif
@endsection

{{-- 🔥 JAVASCRIPT --}}
<script>
// 🔥 UPDATE QUANTITY + SUBTOTAL + ORDER SUMMARY + DB
function updateQty(change, itemId) {
    let qtyInput = document.getElementById("quantity_" + itemId);
    let qty = parseInt(qtyInput.value);
    const price = parseInt(document.getElementById("price_" + itemId).value);

    qty += change;
    if (qty < 1) qty = 1;

    qtyInput.value = qty;
    document.getElementById("qtyDisplay_" + itemId).textContent = qty;

    // UPDATE SUBTOTAL
    let subtotal = qty * price;
    document.getElementById("subtotal_" + itemId).textContent = "₹" + subtotal.toLocaleString();

    // UPDATE ORDER SUMMARY
    updateSummary();

    // SEND UPDATE TO DB
    fetch(`/cart/update/${itemId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(res => res.json())
    .then(data => console.log("Quantity updated"));
}


// 🔥 UPDATE ORDER SUMMARY (subtotal + discount + total)
function updateSummary() {
    let discount = parseFloat(document.getElementById("discountInput").value) || 0;

    let subtotals = document.querySelectorAll("[id^='subtotal_']");
    let total = 0;

    subtotals.forEach(s => {
        total += parseInt(s.textContent.replace(/₹|,/g, ""));
    });

    document.getElementById("summarySubtotal").textContent = "₹" + total.toLocaleString();

    let finalTotal = total - discount;
    if (finalTotal < 0) finalTotal = 0;

    document.getElementById("summaryTotal").textContent = "₹" + finalTotal.toLocaleString();
}



</script>
