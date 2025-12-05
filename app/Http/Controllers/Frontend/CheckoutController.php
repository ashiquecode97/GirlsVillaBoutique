<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        // Ensure only logged-in users can access checkout
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart');
        }

        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        // Handle missing product case safely
        $total = $cartItems->sum(function ($item) {
            return optional($item->product)->price * $item->quantity;
        });

        return view('frontend.checkout.index', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'phone' => 'required',
            'payment_method' => 'required',
        ]);

        // Fetch cart items
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate total
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Create order
        $order = Order::create([
            'user_id'        => auth()->id(),
            'name'           => $request->name,
            'email'          => auth()->user()->email,
            'address'        => $request->address,
            'city'           => $request->city,
            'pincode'        => $request->pincode,
            'phone'          => $request->phone,
            'payment_method' => $request->payment_method,
            'total_amount'   => $total,
            'status'         => 'Pending',
        ]);

        // Save order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'  => $order->id,
                'product_id'=> $item->product_id,
                'quantity'  => $item->quantity,
                'price'     => $item->product->price,
            ]);

            // Update stock
            $item->product->stock -= $item->quantity;
            if ($item->product->stock < 0) {
                $item->product->stock = 0;
            }
            $item->product->save();
        }

        
        // ⭐ SEND ORDER CONFIRMATION EMAIL
        // Mail::to($order->email)->queue(new OrderConfirmedMail($order));
        // After order is created REMOVE invoice mail and send simple mail instead:
        Mail::to($order->email)->send(new OrderPlacedMail($order));

        // Clear cart
        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
    
    
    

}
