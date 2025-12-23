<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\AdminNewOrderMail;

use App\Models\User;
use App\Notifications\NewOrderNotification;


use App\Mail\OrderPlacedMail;
use App\Models\Admin;

class CheckoutController extends Controller
{
    /* ======================
       CHECKOUT PAGE
    ====================== */
    public function index(Request $request)
    {
        // BUY NOW FLOW
        if ($request->buy_now) {

            $product = Product::findOrFail($request->product_id);

            if ($product->stock < $request->qty) {
                return back()->with('error', 'Not enough stock available');
            }

            $cartItems = collect([
                (object)[
                    'product'  => $product,
                    'quantity' => (int) $request->qty,
                    'size'     => $request->size,
                ]
            ]);

            $total = $product->price * $request->qty;

            return view('frontend.checkout.index', compact('cartItems', 'total'));
        }

        // CART FLOW
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum(fn ($i) =>
            $i->product->price * $i->quantity
        );

        return view('frontend.checkout.index', compact('cartItems', 'total'));
    }

    /* ======================
       PLACE ORDER
    ====================== */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'           => 'required',
            'address'        => 'required',
            'city'           => 'required',
            'pincode'        => 'required',
            'phone'          => 'required',
            'payment_method' => 'required',

            'product_id' => 'required_if:buy_now,1',
            'qty'        => 'required_if:buy_now,1|integer|min:1',
            'size'       => 'required_if:buy_now,1',
        ]);

        DB::beginTransaction();

        try {

            /* ======================
               BUY NOW ORDER
            ====================== */
            if ($request->buy_now) {

                $product = Product::lockForUpdate()
                    ->findOrFail($request->product_id);

                if ($product->stock < $request->qty) {
                    throw new \Exception('Not enough stock available');
                }

                $order = Order::create([
                    'user_id'          => auth()->id(),
                    'name'             => $request->name,
                    'email'            => auth()->user()->email,
                    'address'          => $request->address,
                    'city'             => $request->city,
                    'pincode'          => $request->pincode,
                    'phone'            => $request->phone,
                    'payment_method'   => $request->payment_method,
                    'payment_verified' => $request->payment_method === 'cod' ? 1 : 0,
                    'total_amount'     => $product->price * $request->qty,
                    'status'           => 'pending',
                ]);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $request->qty,
                    'price'      => $product->price,
                    'size'       => $request->size,
                ]);

                $product->decrement('stock', $request->qty);
                DB::commit();

                $order->load('items.product');

                try {
                    Mail::to($order->email)
                        ->cc(config('mail.admin_email'))
                        ->send(new OrderPlacedMail($order));
                } catch (\Throwable $e) {
                    // Email failure should not affect order placement
                }

                // Notify admin
                $admin = Admin::first(); // or where('email', 'admin@app.com')

                    if ($admin) {
                        $admin->notify(new NewOrderNotification($order));
                    }



                return redirect()->route('home')
                    ->with('order_popup', true);
            }

            /* ======================
               CART ORDER
            ====================== */
            $cartItems = CartItem::with('product')
                ->where('user_id', auth()->id())
                ->lockForUpdate()
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Your cart is empty');
            }

            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception(
                        'Not enough stock for ' . $item->product->name
                    );
                }
            }

            $total = $cartItems->sum(fn ($i) =>
                $i->product->price * $i->quantity
            );

            $order = Order::create([
                'user_id'          => auth()->id(),
                'name'             => $request->name,
                'email'            => auth()->user()->email,
                'address'          => $request->address,
                'city'             => $request->city,
                'pincode'          => $request->pincode,
                'phone'            => $request->phone,
                'payment_method'   => $request->payment_method,
                'payment_verified' => $request->payment_method === 'cod' ? 1 : 0,
                'total_amount'     => $total,
                'status'           => 'pending',
            ]);

            foreach ($cartItems as $item) {

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'size'       => $item->size,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            CartItem::where('user_id', auth()->id())->delete();

           DB::commit();

            $order->load('items.product');

            try {
                Mail::to($order->email)
                    ->cc(config('mail.admin_email'))
                    ->send(new OrderPlacedMail($order));
            } catch (\Throwable $e) {
                // Email failure should not affect order placement
            }

            // Notify admin
            $admin = Admin::first(); // or where('email', 'admin@app.com')

        if ($admin) {
            $admin->notify(new NewOrderNotification($order));
        }



            return redirect()->route('home')
                ->with('order_popup', true);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }
}
