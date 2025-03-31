<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function index()
    {
        $products = Products::query()
            ->with('category')
            ->when(request('category_id'), function($query) {
                $query->where('category_id', request('category_id'));
            })
            ->latest()
            ->paginate(10);

        $categories = Categories::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function edit(Products $product)
    {
        $categories = Categories::all();
        return view('products.edit', compact('product', 'categories'));
    }
public function update(Request $request, Products $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
        'gst_rate' => 'nullable|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'visibility' => 'required|boolean',
        'hsn_code' => 'nullable|string|max:15',
    ]);

    $product->update([
        'name' => $request->name,
        'purchase_price' => $request->purchase_price,
        'selling_price' => $request->selling_price,
        'category_id' => $request->category_id,
        'stock' => $request->stock,
        'gst_rate' => $request->gst_rate ?? 0,
        'discount' => $request->discount ?? 0,
        'visibility' => $request->visibility,
    'hsn_code' => $request->hsn_code,
    ]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}

public function create()
{
    $categories = Categories::all();
    return view('products.create', compact('categories'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
        'gst_rate' => 'nullable|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'visibility' => 'required|boolean',
        'hsn_code' => 'nullable|string|max:15',
    ]);

    $product = Products::create([
        'name' => $request->name,
        'sku' => 'PROD-' . strtoupper(uniqid()),
        'purchase_price' => $request->purchase_price,
        'selling_price' => $request->selling_price,
        'category_id' => $request->category_id,
        'stock' => $request->stock,
        'gst_rate' => $request->gst_rate ?? 0,
        'discount' => $request->discount ?? 0,
        'visibility' => $request->visibility,
    'hsn_code' => $request->hsn_code,
    ]);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}


public function destroy(Products $product)
{
    try {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error deleting product: ' . $e->getMessage());
    }
}
}
