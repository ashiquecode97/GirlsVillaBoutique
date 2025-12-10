<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product')->where('user_id', Auth::id())->get();
        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        return view('frontend.cart.index', compact('items', 'total'));
    }
        
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'selected_size' => 'required|string'
        ]);

        $size = $request->selected_size;

        // Check if SAME product + SAME size already exists in cart
        $existingItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where('size', $size)
            ->first();

        if ($existingItem) {
            // Update quantity instead of creating duplicate
            $existingItem->quantity += 1;
            $existingItem->save();

            return redirect()->back()->with('success', 'Quantity updated in your cart');
        }

        // Create NEW cart row if size OR product is different
        CartItem::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'size'       => $size,
            'quantity'   => 1,
        ]);

        return redirect()->back()->with('success', 'Product added to cart');
    }

        public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'subtotal' => $cartItem->quantity * $cartItem->product->price,
        ]);
    }


        public function remove(CartItem $cartItem)
    {
        // Ensure user can delete only their own cart item
        if ($cartItem->user_id != auth()->id()) {
            abort(403, "Unauthorized action.");
        }

        $cartItem->delete();

        return redirect()->route('cart.index')
                        ->with('success', 'Item removed from cart.');
    }

}
