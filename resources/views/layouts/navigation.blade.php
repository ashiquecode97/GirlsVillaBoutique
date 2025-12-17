<nav x-data="{ open: false }" class="bg-white shadow-md border-b border-gray-100">
    
    <!-- NAV CONTAINER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- LEFT: LOGO + LINKS -->
            <div class="flex items-center space-x-8">

                <!-- LOGO -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('storage/logo.jpg') }}" alt="GirlsVillaBoutique Logo" class="h-10 w-auto">

                    <span class="text-xl font-semibold tracking-wide text-pink-600">
                        GirlsVillaBoutique
                    </span>
                </a>



                <!-- DESKTOP NAV LINKS -->
                <div class="hidden sm:flex sm:space-x-6">

                    {{-- Home --}}
                    <a href="{{ route('home') }}"
                       class="text-gray-700 hover:text-indigo-600 font-medium relative group">
                        Home
                        <span class="absolute left-0 bottom-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all"></span>
                    </a>

                    {{-- Products --}}
                    <a href="{{ route('products.index') }}"
                       class="text-gray-700 hover:text-indigo-600 font-medium relative group">
                        Products
                        <span class="absolute left-0 bottom-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all"></span>
                    </a>

                    @auth
                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}"
                       class="text-gray-700 hover:text-indigo-600 font-medium relative group flex items-center gap-1">

                        <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-600" fill="none" 
                             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                            <circle cx="9" cy="19" r="2" />
                            <circle cx="17" cy="19" r="2" />
                        </svg>

                        Cart
                        <span class="absolute left-0 bottom-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all"></span>
                    </a>
                    <a href="{{ route('wishlist.index') }}"
                        class="relative flex items-center justify-center text-gray-700 hover:text-pink-600 transition">

                            <!-- Heart Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M12 21s-6.716-4.92-9.543-8.086C-1.02 9.003 1.406 3 6.75 3c2.366 0 3.996 1.46 5.25 3.02C13.254 4.46 14.884 3 17.25 3 22.594 3 25.02 9.003 21.543 12.914 18.716 16.08 12 21 12 21z"/>
                            </svg>

                            <!-- Badge -->
                            @if($wishlistCount > 0)
                                <span
                                    class="absolute -top-2 -right-2
                                        bg-pink-600 text-white text-xs
                                        min-w-[18px] h-[18px]
                                        flex items-center justify-center
                                        rounded-full font-bold">
                                    {{ $wishlistCount }}
                                </span>
                            @endif
                    </a>
                    @endauth
                </div>
            </div>

            <!-- RIGHT: USER MENU -->
            <div class="hidden sm:flex items-center space-x-4">

                @auth
                    <!-- Avatar Dropdown -->
                    <div class="relative">
                        <button @click="open = !open"
                                class="flex items-center space-x-2 px-3 py-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            
                            <span class="font-medium text-gray-700">{{ Auth::user()->name }}</span>

                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4F46E5&color=fff"
                                 class="h-8 w-8 rounded-full">
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg py-2 z-50">
                                    <x-dropdown-link :href="route('user.orders')">
                                        My Orders
                                    </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-700 hover:text-indigo-600 font-medium">Login</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                       Register
                    </a>
                @endauth
            </div>

            <!-- MOBILE MENU BUTTON -->
            <button @click="open = !open"
                    class="sm:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- MOBILE DROPDOWN -->
    <div x-show="open" class="sm:hidden bg-white border-t">

        <a href="{{ route('home') }}"
           class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>

        <a href="{{ route('products.index') }}"
           class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Products</a>

        @auth
            <a href="{{ route('cart.index') }}"
               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Cart</a>
                        <x-dropdown-link :href="route('user.orders')">
                                    My Orders
                        </x-dropdown-link>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Login</a>

            <a href="{{ route('register') }}"
               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Register</a>
        @endauth
    </div>
</nav>
