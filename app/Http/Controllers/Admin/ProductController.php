<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(6);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        
            'name' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048',
             'size' => 'nullable|array',
            'is_active' => 'required|boolean',
        ]);

        
        // Auto-generate product code
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $nextId = $lastProduct ? $lastProduct->id + 1 : 1;

        $validated['product_code'] = 'GV-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);



        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['size'] = $request->size ? implode(',', $request->size) : null;


        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
          
            'name' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'size' => 'nullable|array',
            'is_active' => 'required|boolean',
        ]);

        // Save image
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Save size (convert array → comma-separated)
        $validated['size'] = $request->size ? implode(',', $request->size) : null;

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Updated successfully');
    }


    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Deleted');
    }
 

}
