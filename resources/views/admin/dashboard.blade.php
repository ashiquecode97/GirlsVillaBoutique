
@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Welcome, Admin 👋</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
            <h2 class="text-sm font-semibold text-blue-700 mb-1">Total Products</h2>
            <p class="text-2xl font-bold text-blue-900">
                {{ \App\Models\Product::count() }}
            </p>
        </div>

        <div class="bg-green-50 border border-green-100 rounded-lg p-4">
            <h2 class="text-sm font-semibold text-green-700 mb-1">Active Products</h2>
            <p class="text-2xl font-bold text-green-900">
                {{ \App\Models\Product::where('is_active', true)->count() }}
            </p>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <h2 class="text-sm font-semibold text-gray-700 mb-1">Admin Tools</h2>
            <p class="text-sm text-gray-600">
                Use the sidebar to manage products and settings.
            </p>
        </div>

    </div>
@endsection
