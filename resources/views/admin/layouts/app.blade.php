<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin – {{ config('app.name', 'E-Commerce') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gray-900 text-gray-100 flex flex-col">
        <div class="px-6 py-4 border-b border-gray-700">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <p class="text-xs text-gray-400 mt-1">
                {{ config('app.name', 'E-Commerce') }}
            </p>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-3 py-2 rounded-md text-sm
               {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="block px-3 py-2 rounded-md text-sm
               {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                Products
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="block px-3 py-2 rounded-md text-sm
               {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                Orders
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-gray-700">
            <a href="{{ route('admin.logout') }}"
               class="block w-full px-3 py-2 text-left rounded-md text-sm
               text-red-300 hover:bg-red-600 hover:text-white">
                Logout
            </a>
        </div>
    </aside>

    {{-- MAIN AREA --}}
    <div class="flex-1 flex flex-col">

        {{-- TOP BAR --}}
        <header class="h-16 bg-white dark:bg-gray-800 shadow flex items-center justify-between px-6">
            <h2 class="text-lg font-semibold">
                @yield('title', 'Admin')
            </h2>

            <div class="flex items-center gap-4 text-sm">

                {{-- Dark Mode --}}
                <button onclick="document.documentElement.classList.toggle('dark')"
                        class="px-3 py-1 rounded-lg border text-xs
                               dark:border-gray-700">
                    🌗 Dark
                </button>

                {{-- Notifications --}}
            @php
                $admin = \App\Models\Admin::find(session('admin_id'));
                $notifications = $admin?->unreadNotifications ?? collect();
            @endphp


<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative focus:outline-none">
        🔔
        @if($notifications->count())
            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 rounded-full">
                {{ $notifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open"
         @click.outside="open = false"
         class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 shadow-lg rounded z-50">

        @forelse($notifications as $note)
            <a href="{{ route('admin.notifications.read', $note->id) }}"
               class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                🛒 Order #{{ $note->data['order_id'] }}<br>
                <span class="text-gray-500">
                    {{ $note->data['customer'] }} — ₹{{ number_format($note->data['amount']) }}
                </span>
            </a>
        @empty
            <p class="px-4 py-2 text-gray-500 text-sm">No new notifications</p>
        @endforelse
    </div>
</div>




                <span class="text-gray-500 dark:text-gray-400">
                    Admin
                </span>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6 bg-gray-100 dark:bg-gray-900">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
