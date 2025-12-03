<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ShopController extends Controller
{
    public function home()
    {
        $products = Product::where('is_active', true)->latest()->take(8)->get();
        return view('frontend.home', compact('products'));
    }

    public function products()
    {
        $products = Product::where('is_active', true)->paginate(12);
        return view('frontend.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);
        return view('frontend.products.show', compact('product'));
    }
}
