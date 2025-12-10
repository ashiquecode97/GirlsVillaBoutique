<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;

class UserOrderController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.orders.index', compact('orders'));
    }

        public function show(Order $order)
    {
        // Prevent access to others' orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $order->load('items.product');

        return view('user.orders.show', compact('order'));
    }

}
