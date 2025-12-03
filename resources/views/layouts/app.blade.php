<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel E-commerce') }}</title>
      <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex flex-col">

        {{-- NAV BAR --}}
        @include('layouts.navigation')

        {{-- PAGE CONTENT --}}
        <main class="flex-grow container mx-auto px-4 py-6">
            <div class="bg-white rounded-lg shadow p-6">
                @yield('content')
            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="bg-gray-900 text-white text-center py-4 mt-6">
            <p class="text-sm">&copy; {{ date('Y') }} My E-Commerce. All Rights Reserved.</p>
        </footer>

    </div>
</body>
</html>
