<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Show wishlist page
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->get();

        return view('frontend.wishlist.index', compact('wishlists'));
    }

    // Add / Remove wishlist
    public function toggle(Product $product)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Removed from wishlist');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Added to wishlist ❤️');
    }

    // Remove wishlist item
    public function destroy(Wishlist $wishlist)
    {
        abort_if($wishlist->user_id !== auth()->id(), 403);

        $wishlist->delete();
        return back()->with('success', 'Removed from wishlist');
    }
}
