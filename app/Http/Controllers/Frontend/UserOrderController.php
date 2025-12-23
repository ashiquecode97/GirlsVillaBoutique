<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderCancelledMail;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;


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

    public function cancel(Order $order)
    {
        // 🔒 Security: only owner can cancel
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        
        $status = strtolower($order->status);

        // ❌ Block cancel after  delivered / cancelled
        if (in_array($order->status, [ 'delivered', 'cancelled'])) {
            return back()->with('error', '❌ Once an order is success or delivered, it must NOT be cancelled');
        }

        // ⏱ Optional: 24 hours cancellation window (only for pending)
        if ($order->created_at->diffInHours(now()) > 24) {
            return back()->with('error', '⏱ Cancellation period (24 hours) has expired.');
        }

        DB::transaction(function () use ($order) {

            // 🔄 Restore stock
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // ✅ Update order status (use lowercase for consistency)
            $order->update([
                'status' => 'cancelled',
            ]);
        });

            // 📧 SEND CANCEL EMAIL
        Mail::to($order->email)->send(new OrderCancelledMail($order));

        return back()->with('success', 'Order cancelled successfully.');
    }

        public function invoice(Order $order)
    {
        // 🔐 Security: only owner can download
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        $pdf = Pdf::loadView('user.orders.invoice', compact('order'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('invoice-'.$order->id.'.pdf');
    }


}
