<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
      <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100">

<div class="flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow w-96">

        <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>

        @if(session('error'))
            <p class="text-red-600 text-sm mb-3">{{ session('error') }}</p>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <label class="block mb-2 font-medium">Email</label>
            <input type="email" name="email" class="w-full px-3 py-2 border rounded mb-4" required>

            <label class="block mb-2 font-medium">Password</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded mb-6" required>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>

    </div>
</div>

</body>
</html>
