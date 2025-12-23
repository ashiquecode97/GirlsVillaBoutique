<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts'  => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'todaySales'     => Order::whereDate('created_at', today())->sum('total_amount'),
            'monthlySales'   => Order::whereMonth('created_at', now()->month)->sum('total_amount'),

            'statusCounts'   => Order::selectRaw('LOWER(status) as status, COUNT(*) as total')
                                    ->groupBy('status')
                                    ->pluck('total', 'status'),
        ]);
    }
}
