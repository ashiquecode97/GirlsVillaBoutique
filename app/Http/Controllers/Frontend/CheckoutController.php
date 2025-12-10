<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
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
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart');
        }

        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return optional($item->product)->price * $item->quantity;
        });

        return view('frontend.checkout.index', compact('cartItems', 'total'));
    }


    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'phone' => 'required',
            'payment_method' => 'required',
        ]);

        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(fn($item) =>
            optional($item->product)->price * $item->quantity
        );

        DB::beginTransaction();

        try {
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

            // Create order items + update stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'size'       => $item->size,
                ]);

                if ($item->product) {
                    $item->product->stock -= $item->quantity;
                    if ($item->product->stock < 0) {
                        $item->product->stock = 0;
                    }
                    $item->product->save();
                }
            }

            // SEND MAIL ✔
            Mail::to($order->email)->send(new OrderPlacedMail($order));

            // CLEAR CART ✔
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('home')->with('success', 'Order placed successfully!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Something went wrong while placing the order. Please try again.');
        }
    }
}
