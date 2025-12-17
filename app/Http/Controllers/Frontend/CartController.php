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
        // ❌ Block if out of stock
        if ($product->stock <= 0) {
            return redirect()->back()
                ->with('error', 'This product is out of stock.');
        }

        $request->validate([
            'selected_size' => 'required|string'
        ]);

        $size = $request->selected_size;

        $existingItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where('size', $size)
            ->first();

        if ($existingItem) {

            // ❌ Prevent exceeding stock
            if ($existingItem->quantity + 1 > $product->stock) {
                return redirect()->back()
                    ->with('error', 'No more stock available.');
            }

            $existingItem->quantity += 1;
            $existingItem->save();

            return redirect()->back()->with('success', 'Quantity updated in your cart');
        }

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
        // Security: ensure user owns this cart item
        if ($cartItem->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $quantity = max(1, (int) $request->quantity);

        // Optional: stock check
        if ($cartItem->product->stock < $quantity) {
            return response()->json([
                'error' => 'Not enough stock available'
            ], 422);
        }

        // ✅ UPDATE DB
        $cartItem->quantity = $quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'quantity' => $cartItem->quantity
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
