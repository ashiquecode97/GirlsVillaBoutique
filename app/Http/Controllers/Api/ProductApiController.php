<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    public function index()
    {
        return Product::where('is_active', true)->paginate(10);
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);
        return $product;
    }
}
