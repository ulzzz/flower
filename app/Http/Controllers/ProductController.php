<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'quantity' => 'nullable|integer',
            'price' => 'required|numeric',
            'status' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['status'] = $data['status'] ?? 1;
        return Product::create($data);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'sometimes|string|max:255',
            'product_description' => 'sometimes|string',
            'quantity' => 'integer',
            'price' => 'sometimes|numeric',
            'status' => 'sometimes|boolean',
        ]);

        $product->update($request->all());
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }

    public function toggleStatus(Product $product)
    {
        $product->status = !$product->status;
        $product->save();
        return $product;
    }
}
