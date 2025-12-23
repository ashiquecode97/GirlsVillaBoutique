@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold">Admin Dashboard</h1>
    <p class="text-gray-500">Order Status Overview</p>
</div>

{{-- KPI CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-indigo-600 text-white p-5 rounded shadow">
        <p>Total Products</p>
        <p class="text-3xl font-bold">{{ $totalProducts }}</p>
    </div>

    <div class="bg-green-600 text-white p-5 rounded shadow">
        <p>Active Products</p>
        <p class="text-3xl font-bold">{{ $activeProducts }}</p>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500">Today Sales</p>
        <p class="text-2xl font-bold text-indigo-600">
            ₹ {{ number_format($todaySales) }}
        </p>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500">Monthly Sales</p>
        <p class="text-2xl font-bold text-green-600">
            ₹ {{ number_format($monthlySales) }}
        </p>
    </div>

</div>

{{-- STATUS TABLE --}}
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">
        📦 Orders by Status
    </h2>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b text-gray-600">
                <th class="text-left py-2">Status</th>
                <th class="text-right py-2">Total Orders</th>
            </tr>
        </thead>
        <tbody>
            @foreach (['pending','success','delivered','cancelled'] as $status)
                <tr class="border-b">
                    <td class="py-2 capitalize">{{ $status }}</td>
                    <td class="py-2 text-right font-bold">
                        {{ $statusCounts[$status] ?? 0 }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
