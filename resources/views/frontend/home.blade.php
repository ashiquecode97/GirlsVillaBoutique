@extends('layouts.app')

@section('content')

{{-- 🔥 HERO SLIDER --}}
<div
    x-data="{
        active: 0,
        loaded: false,
        timer: null,
        slides: [
            {
                title: 'Big Winter Sale ❄️',
                subtitle: 'Up to 50% OFF on Electronics & Accessories',
                image: '{{ asset("storage/slider4.jpg") }}'
            },
            {
                title: 'New Arrivals 🚀',
                subtitle: 'Latest Gadgets at Best Prices',
                image: '{{ asset("storage/slider5.jpg") }}'
            },
            {
                title: 'Top Brands ⭐',
                subtitle: 'Premium Quality Products',
                image: '{{ asset("storage/slider3.jpg") }}'
            }
        ],
        start() {
            this.timer = setInterval(() => {
                this.active = (this.active + 1) % this.slides.length
            }, 5000)
        },
        stop() {
            clearInterval(this.timer)
        }
    }"
    x-init="
        loaded = true;
        start();
    "
    @mouseenter="stop()"
    @mouseleave="start()"
    class="relative h-64 md:h-80 rounded-2xl overflow-hidden mb-10 shadow-2xl bg-black"
>

    <template x-for="(slide, index) in slides" :key="index">
        <div
            x-cloak
            class="absolute inset-0 transition-opacity duration-700"
            :class="{
                'opacity-100 z-10': active === index && loaded,
                'opacity-0 z-0': active !== index || !loaded
            }"
        >
            <img :src="slide.image"
                 loading="lazy"
                 class="w-full h-full object-cover">

            <div class="absolute inset-0 bg-black/50 flex flex-col
                        justify-center items-center text-center text-white px-4">
                <h1 class="text-3xl md:text-4xl font-extrabold mb-2"
                    x-text="slide.title"></h1>

                <p class="text-lg md:text-xl mb-4"
                   x-text="slide.subtitle"></p>

                <a href="#products"
                   class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-pink-500
                          text-white rounded-lg font-semibold shadow
                          hover:scale-105 transition">
                    Shop Now
                </a>
            </div>
        </div>
    </template>

    {{-- Controls --}}
    <button @click="active = (active - 1 + slides.length) % slides.length"
        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/30
               hover:bg-white/50 text-white w-10 h-10 rounded-full">❮</button>

    <button @click="active = (active + 1) % slides.length"
        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/30
               hover:bg-white/50 text-white w-10 h-10 rounded-full">❯</button>

    {{-- Dots --}}
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
        <template x-for="(_, index) in slides" :key="index">
            <button @click="active = index"
                :class="active === index ? 'bg-white' : 'bg-white/50'"
                class="w-3 h-3 rounded-full"></button>
        </template>
    </div>
</div>

{{-- 🛒 PRODUCTS --}}
<div id="products"
     class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

@foreach($products as $product)
<div
    x-data="{ hover: false }"
    @mouseenter="hover = true"
    @mouseleave="hover = false"
    class="group bg-white rounded-2xl shadow-md hover:shadow-2xl
           transition-all duration-500 border overflow-hidden"
>

    {{-- Image --}}
    <div class="relative overflow-hidden">
        <img src="{{ asset('storage/'.$product->image) }}"
             loading="lazy"
             class="w-full h-52 object-cover transform
                    group-hover:scale-110 transition duration-700">

        @if($product->discount ?? false)
        <span class="absolute top-3 left-3 bg-red-500 text-white
                     text-xs px-3 py-1 rounded-full">
            {{ $product->discount }}% OFF
        </span>
        @endif

        {{-- Hover Tools --}}
        <div x-show="hover"
             x-transition.opacity.scale
             class="absolute top-4 right-3 flex flex-col gap-2">

            <a href="{{ route('products.show', $product) }}"
               class="w-9 h-9 bg-white rounded-full shadow flex
                      items-center justify-center hover:bg-indigo-600 hover:text-white">
                👁️
            </a>

            @auth
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <button class="w-9 h-9 bg-green-600 text-white rounded-full">🛒</button>
            </form>
            @else
            <button onclick="openLoginModal()"
                    class="w-9 h-9 bg-gray-100 rounded-full">🛒</button>
            @endauth

            @auth
            <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                @csrf
                <button class="w-9 h-9 rounded-full
                    {{ in_array($product->id, $wishlistIds ?? [])
                        ? 'bg-pink-500 text-white'
                        : 'bg-pink-100 text-pink-600' }}">
                    ❤️
                </button>
            </form>
            @else
            <button onclick="openLoginModal()"
                    class="w-9 h-9 bg-pink-100 text-pink-600 rounded-full">❤️</button>
            @endauth
        </div>
    </div>

    {{-- Info --}}
    <div class="p-4">
        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
        <p class="text-sm text-gray-500">
            {{ Str::limit($product->description, 50) }}
        </p>

        <div class="flex justify-between items-center mt-4">
            <span class="text-xl font-bold text-green-600">
                ₹{{ number_format($product->price) }}
            </span>

            <a href="{{ route('products.show', $product) }}"
               class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                View
            </a>
        </div>
    </div>
</div>
@endforeach

</div>

{{-- 🔐 LOGIN REQUIRED MODAL --}}
<div id="loginRequiredModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

    <div class="bg-white w-[90%] max-w-sm rounded-2xl p-6 text-center space-y-4">
        <h2 class="text-xl font-bold">🔐 Login Required</h2>
        <p class="text-gray-600">Please login to continue.</p>

        <a href="{{ route('login') }}"
           class="block w-full py-3 bg-indigo-600 text-white rounded-lg">
            Login
        </a>

        <button onclick="closeLoginModal()"
                class="text-sm text-gray-500 hover:underline">
            Cancel
        </button>
    </div>
</div>

@if(session('order_popup'))
<div
    x-data="{ open: true }"
    x-show="open"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">

    <div
        class="bg-white max-w-md w-[90%] rounded-2xl p-7 text-center space-y-5 shadow-2xl">

        <div class="text-green-600 text-5xl animate-bounce">✅</div>

        <h2 class="text-2xl font-bold text-gray-800">
            Order Placed Successfully
        </h2>

        <p class="text-gray-600 leading-relaxed">
            Your order has been placed successfully.<br>
            Once your payment is verified, you will be notified via email.
        </p>

        <button
            @click="open = false"
            class="w-full mt-2 py-3 bg-gradient-to-r from-indigo-600 to-purple-600
                   text-white rounded-xl font-semibold hover:scale-105 transition">
            Continue Shopping
        </button>
    </div>
</div>
@endif

<script>
function openLoginModal() {
    loginRequiredModal.classList.remove('hidden');
    loginRequiredModal.classList.add('flex');
}
function closeLoginModal() {
    loginRequiredModal.classList.add('hidden');
    loginRequiredModal.classList.remove('flex');
}
</script>

@endsection
