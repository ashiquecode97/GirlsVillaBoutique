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
use App\Mail\OrderPlacedMail;

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
                    'product' => $product,
                    'quantity' => (int) $request->qty,
                    'size' => $request->size,
                ]
            ]);

            $total = $product->price * $request->qty;

            return view('frontend.checkout.index', compact('cartItems', 'total'));
        }

        // NORMAL CART FLOW
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);

        return view('frontend.checkout.index', compact('cartItems', 'total'));
    }

    /* ======================
       PLACE ORDER
    ====================== */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'phone' => 'required',
            'payment_method' => 'required',

            // Buy now fields
            'product_id' => 'required_if:buy_now,1',
            'qty' => 'required_if:buy_now,1|integer|min:1',
            'size' => 'required_if:buy_now,1',
        ]);

        DB::beginTransaction();

        try {

            /* ===== BUY NOW ORDER ===== */
            if ($request->has('buy_now')) {

                $product = Product::findOrFail($request->product_id);

                if ($product->stock < $request->qty) {
                    return back()->with('error', 'Not enough stock');
                }

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'name' => $request->name,
                    'email' => auth()->user()->email,
                    'address' => $request->address,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                    'phone' => $request->phone,
                    'payment_method' => $request->payment_method,
                    'total_amount' => $product->price * $request->qty,
                    'status' => 'Pending',
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $request->qty,
                    'price' => $product->price,
                    'size' => $request->size,
                ]);

                $product->decrement('stock', $request->qty);

                Mail::to($order->email)->send(new OrderPlacedMail($order));

                DB::commit();

                return redirect()->route('home')
                    ->with('success', 'Order placed successfully!');
            }

            /* ===== CART ORDER ===== */
            $cartItems = CartItem::with('product')
                ->where('user_id', auth()->id())
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty');
            }

            $total = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);

            $order = Order::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'email' => auth()->user()->email,
                'address' => $request->address,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
                'total_amount' => $total,
                'status' => 'Pending',
            ]);

            foreach ($cartItems as $item) {

                if ($item->product->stock < $item->quantity) {
                    throw new \Exception('Out of stock');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'size' => $item->size,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            CartItem::where('user_id', auth()->id())->delete();

            Mail::to($order->email)->send(new OrderPlacedMail($order));

            DB::commit();

            return redirect()->route('home')
                ->with('success', 'Order placed successfully!');

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->route('cart.index')
                ->with('error', 'Some items are out of stock. Please try again.');
        }
    }
}
