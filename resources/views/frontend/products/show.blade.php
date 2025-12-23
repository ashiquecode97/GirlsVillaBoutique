@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

        {{-- IMAGE SECTION --}}
        <div class="bg-white p-5 rounded-3xl shadow-lg space-y-4">

            <div class="relative rounded-2xl overflow-hidden cursor-pointer"
                 onclick="openZoomModal()">
                <img id="mainImage"
                     src="{{ asset('storage/'.$product->image) }}"
                     class="w-full h-[360px] object-cover">
            </div>

            <div class="flex gap-3 overflow-x-auto">
                @foreach(explode(',', $product->images ?? $product->image) as $img)
                    <img src="{{ asset('storage/'.$img) }}"
                         onclick="changeImage(this)"
                         class="w-16 h-16 object-cover rounded-xl cursor-pointer border">
                @endforeach
            </div>
        </div>

        {{-- DETAILS --}}
        <div class="bg-white p-7 rounded-3xl shadow-lg space-y-6">

            <h1 class="text-3xl font-bold">{{ $product->name }}</h1>

                        {{-- PRICE + WISHLIST --}}
            <div class="flex items-center justify-between">

                <p class="text-3xl font-extrabold text-green-600">
                    ₹{{ number_format($product->price) }}
                </p>

                {{-- WISHLIST --}}
                @auth
                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                        @csrf
                        <button
                            class="flex items-center gap-2 px-4 py-2 rounded-full border
                            {{ auth()->user()->wishlists->contains('product_id', $product->id)
                                ? 'bg-pink-100 border-pink-400 text-pink-600'
                                : 'hover:bg-pink-50 border-pink-200 text-pink-600' }}
                            transition">
                            ❤️
                            <span class="text-sm font-semibold">
                                {{ auth()->user()->wishlists->contains('product_id', $product->id)
                                    ? 'Wishlisted'
                                    : 'Wishlist' }}
                            </span>
                        </button>
                    </form>
                @else
                    <button
                        onclick="openLoginModal()"
                        class="flex items-center gap-2 px-4 py-2 rounded-full border
                            border-pink-200 text-pink-600 hover:bg-pink-50 transition">
                        ❤️
                        <span class="text-sm font-semibold">Wishlist</span>
                    </button>
                @endauth

            </div>


            {{-- STOCK --}}
            <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold
                {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
            </span>

            {{-- DESCRIPTION --}}
            <p class="text-gray-600">{{ $product->description }}</p>

            {{-- SIZE --}}
            @if($product->size)
            <div>
                <h4 class="text-lg font-semibold mb-3">Select Size</h4>

                <div class="flex flex-wrap gap-3">
                    @foreach(explode(',', $product->size) as $size)
                        <button type="button"
                            class="size-btn px-6 py-2 rounded-full border-2 text-sm font-semibold
                                   border-gray-300 text-gray-700 hover:border-indigo-600"
                            onclick="selectSize('{{ $size }}', event)">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>

                {{-- SIZE MESSAGE --}}
                <p id="sizeMessage"
                   class="hidden mt-2 text-sm font-semibold text-red-600">
                    ⚠ Please select a size first
                </p>
            </div>
            @endif

           
                {{-- ADD TO CART --}}
                @if($product->stock > 0)

                    @auth
                        <form action="{{ route('cart.add', $product) }}"
                            method="POST"
                            onsubmit="return validateSize()">
                            @csrf
                            <input type="hidden" name="selected_size" id="selected_size">

                            <button
                                class="mt-4 px-10 py-3 bg-indigo-600 text-white rounded-full font-semibold">
                                🛒 Add to Cart
                            </button>
                        </form>
                    @else
                        <button
                            type="button"
                            onclick="openLoginModal()"
                            class="mt-4 px-10 py-3 bg-indigo-600 text-white rounded-full font-semibold">
                            🛒 Add to Cart
                        </button>
                    @endauth

                @endif


                {{-- BUY NOW --}}
                @if($product->stock > 0)

                    @auth
                        <button
                            type="button"
                            onclick="openBuyNowModalChecked()"
                            class="mt-3 px-10 py-3 bg-green-600 text-white rounded-full font-semibold">
                            ⚡ Buy Now
                        </button>
                    @else
                        <button
                            type="button"
                            onclick="openLoginModal()"
                            class="mt-3 px-10 py-3 bg-green-600 text-white rounded-full font-semibold">
                            ⚡ Buy Now
                        </button>
                    @endauth

                @endif


        </div>
    </div>
</div>

{{-- BUY NOW MODAL --}}
<div id="buyNowModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

    <div class="bg-white w-[90%] max-w-md rounded-2xl p-6 space-y-5">

        <h2 class="text-xl font-bold text-gray-800">Buy Now</h2>

        {{-- HIDDEN SIZE --}}
        <input type="hidden" id="buyNowHiddenSize">

        {{-- QUANTITY --}}
        <div>
            <label class="block font-semibold mb-2">Quantity</label>
            <input type="number"
                   id="buyNowQty"
                   min="1"
                   max="{{ $product->stock }}"
                   value="1"
                   class="w-full border rounded-lg px-3 py-2">
            <p class="text-xs text-gray-500 mt-1">
                Max {{ $product->stock }} available
            </p>
        </div>

        {{-- ACTION --}}
        <button
            onclick="buyNowProceed()"
            class="w-full py-3 bg-green-600 hover:bg-green-700
                   text-white rounded-lg font-semibold transition">
            Continue to Checkout →
        </button>

        <button
            onclick="closeBuyNowModal()"
            class="w-full py-2 text-gray-600 text-sm">
            Cancel
        </button>
    </div>
</div>
{{-- LOGIN REQUIRED MODAL --}}
<div id="loginRequiredModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

    <div class="bg-white w-[90%] max-w-sm rounded-2xl p-6 text-center space-y-5">

        <h2 class="text-xl font-bold text-gray-800">
            🔐 Login Required
        </h2>

        <p class="text-gray-600">
            Please login to continue shopping.
        </p>

        <a href="{{ route('login') }}"
           class="block w-full py-3 bg-indigo-600 hover:bg-indigo-700
                  text-white rounded-lg font-semibold transition">
            Login
        </a>

        <button onclick="closeLoginModal()"
                class="text-sm text-gray-500 hover:underline">
            Cancel
        </button>
    </div>
</div>


@endsection

{{-- JS --}}
<script>
function selectSize(size, event) {
    document.getElementById('selected_size').value = size;
    document.getElementById('sizeMessage').classList.add('hidden');

    document.querySelectorAll('.size-btn').forEach(btn =>
        btn.classList.remove('bg-indigo-600','text-white','border-indigo-600')
    );

    event.target.classList.add('bg-indigo-600','text-white','border-indigo-600');
}

function validateSize() {
    if (!document.getElementById('selected_size').value) {
        const msg = document.getElementById('sizeMessage');
        msg.classList.remove('hidden');
        msg.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    return true;
}
function openBuyNowModalChecked() {
    const size = document.getElementById('selected_size').value;

    // 🔒 Require size selection first
    if (!size) {
        const msg = document.getElementById('sizeMessage');
        msg.classList.remove('hidden');
        msg.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    // ✅ Store size internally (hidden)
    document.getElementById('buyNowHiddenSize').value = size;

    // ✅ Open modal
    document.getElementById('buyNowModal').classList.remove('hidden');
    document.getElementById('buyNowModal').classList.add('flex');
}


function closeBuyNowModal() {
    document.getElementById('buyNowModal').classList.add('hidden');
}

function buyNowProceed() {
    const size = document.getElementById('buyNowHiddenSize').value;
    const qty  = document.getElementById('buyNowQty').value;

    if (qty < 1) return;

    window.location.href =
        "{{ route('checkout.index') }}" +
        "?buy_now=1" +
        "&product_id={{ $product->id }}" +
        "&size=" + size +
        "&qty=" + qty;
}


function changeImage(el) {
    document.getElementById('mainImage').src = el.src;
}


function openLoginModal() {
    document.getElementById('loginRequiredModal')
        .classList.remove('hidden');
    document.getElementById('loginRequiredModal')
        .classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLoginModal() {
    document.getElementById('loginRequiredModal')
        .classList.add('hidden');
    document.getElementById('loginRequiredModal')
        .classList.remove('flex');
    document.body.style.overflow = '';
}


</script>
