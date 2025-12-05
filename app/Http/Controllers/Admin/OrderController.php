<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmedMail;   // Only necessary mail class
use App\Mail\OrderStatusUpdatedMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('id', $request->search);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('id', 'DESC')->paginate(5);

        return view('admin.orders.index', compact('orders'));
    }


    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }


    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $oldStatus = $order->status;  // Save previous status
        $newStatus = $request->status;

        // Update status
        $order->status = $newStatus;
        $order->save();

        // Send EMAIL to customer
        Mail::to($order->email)->send(
            new OrderStatusUpdatedMail($order, $oldStatus, $newStatus)
        );

        return redirect()->back()->with('success', 'Order Status Updated & Email Sent!');
    }



    public function invoice(Order $order)
    {
        $pdf = Pdf::loadView('admin.orders.invoice', compact('order'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('invoice-'.$order->id.'.pdf');
    }


    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }
}
