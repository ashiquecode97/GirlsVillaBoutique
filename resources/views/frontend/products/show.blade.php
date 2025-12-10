@extends('layouts.app')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <img src="{{ asset('storage/'.$product->image) }}"
         class="w-full rounded-lg shadow">

    <div>
        <h1 class="text-3xl font-bold mb-3">{{ $product->name }}</h1>

        <p class="text-gray-600 mb-4">{{ $product->description }}</p>

        {{-- SIZE SELECTION --}}
        @if($product->size)
            <div class="mt-4">
                <h4 class="text-md font-semibold mb-2">Select Size</h4>

                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $product->size) as $size)
                        <button 
                            type="button"
                            class="size-btn px-4 py-2 border rounded-lg text-sm font-semibold
                                hover:border-indigo-500 hover:text-indigo-600 transition cursor-pointer"
                            onclick="selectSize('{{ $size }}', event)">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>

                {{-- Add to Cart Form --}}
                <form action="{{ route('cart.add', $product) }}" method="POST" onsubmit="return validateSize()">
                    @csrf

                    <input type="hidden" name="selected_size" id="selected_size">

                    <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Add to Cart
                    </button>

                    <p id="sizeError" class="text-red-600 text-sm mt-2 hidden">Please select a size.</p>
                </form>


            </div>
        @endif

        <p class="text-2xl font-semibold text-green-600 mt-6">
            Only ₹{{ $product->price }}/-
        </p>

        {{-- If NOT logged in --}}
        @guest
            <p class="text-sm text-gray-700 mt-3">
                <a href="{{ route('login') }}" class="text-blue-600 underline">Login</a>
                to add this product to your cart.
            </p>
        @endguest

    </div>

</div>

@endsection

{{-- JS --}}
<script>
function selectSize(size, event) {
    document.getElementById("selected_size").value = size;

    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
    });

    event.target.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
}

function validateSize() {
    if (!document.getElementById("selected_size").value) {
        document.getElementById("sizeError").classList.remove("hidden");
        return false;
    }
    return true;
}

</script>
