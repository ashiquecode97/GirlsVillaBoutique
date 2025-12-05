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

    <!-- SOUND -->
    <audio id="toast-sound" src="{{ asset('sounds/notify.OGG') }}"></audio>

    <div class="min-h-screen flex flex-col">

        {{-- NAV BAR --}}
        @include('layouts.navigation')

        {{-- TOAST ALERTS --}}
        <div id="toast-container" class="fixed top-5 right-5 z-50 space-y-3">
            @if(session('success'))
                <div id="toast-success"
                     class="toast-message bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-3 
                     transition-all duration-700 opacity-0 translate-x-10">
                    <span>✔</span>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div id="toast-error"
                     class="toast-message bg-red-600 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-3 
                     transition-all duration-700 opacity-0 translate-x-10">
                    <span>⚠️</span>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const sound = document.getElementById('toast-sound');
                const toasts = document.querySelectorAll('.toast-message');

                toasts.forEach((toast) => {

                    // SLIDE + FADE IN
                    setTimeout(() => {
                        toast.classList.remove("opacity-0", "translate-x-10");
                        toast.classList.add("opacity-100");
                        sound.play(); // PLAY SOUND
                    }, 200);

                    // FADE OUT AFTER 4 SECONDS
                    setTimeout(() => {
                        toast.classList.add("opacity-0");
                        toast.classList.remove("opacity-100");
                        toast.classList.add("translate-x-10");
                    }, 4000);

                    // REMOVE FROM DOM
                    setTimeout(() => toast.remove(), 4700);
                });
            });
        </script>

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
