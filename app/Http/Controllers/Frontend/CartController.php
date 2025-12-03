<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product')->where('user_id', Auth::id())->get();
        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        return view('frontend.cart.index', compact('items', 'total'));
    }

    public function add(Product $product)
    {
        $item = CartItem::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['quantity' => 0]
        );

        $item->quantity++;
        $item->save();

        return redirect()->route('cart.index');
    }

    public function remove(CartItem $cartItem)
    {
        abort_if($cartItem->user_id !== Auth::id(), 403);
        $cartItem->delete();

        return back();
    }
}
