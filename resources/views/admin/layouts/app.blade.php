<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin – {{ config('app.name', 'E-Commerce') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gray-900 text-gray-100 flex flex-col">
        <div class="px-6 py-4 border-b border-gray-700">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <p class="text-xs text-gray-400 mt-1">{{ config('app.name', 'E-Commerce') }}</p>
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
               class="block w-full text-left px-3 py-2 rounded-md text-sm text-red-300 hover:bg-red-600 hover:text-white">
                Logout
            </a>
        </div>
    </aside>

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-1 flex flex-col">

        {{-- TOP BAR --}}
        <header class="h-16 bg-white shadow flex items-center justify-between px-6">
            <h2 class="text-lg font-semibold">
                @yield('title', 'Admin')
            </h2>

            <div class="text-sm text-gray-500">
                Logged in as <span class="font-semibold">Admin</span>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow p-6">
                @yield('content')
            </div>
        </main>

    </div>
</div>

</body>
</html>
