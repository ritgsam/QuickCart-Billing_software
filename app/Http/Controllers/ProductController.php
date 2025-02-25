<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Log;
class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Products::query();

    if ($request->has('category_id') && $request->category_id != '') {
        $query->where('category_id', $request->category_id);
    }

    $products = $query->get();
    $categories = Categories::all();

    return view('products.index', compact('products', 'categories'));
}


    public function create()
    {
        $categories = Categories::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
        'purchase_price' => 'required|numeric',
        'selling_price' => 'required|numeric',
        'visibility' => 'required|boolean',
        'stock' => 'required|integer',
        'tax_rate' => 'nullable|numeric',
        'hsn_code' => 'nullable|string|max:255',
    ]);

    $validatedData['price'] = 30000;

    $validatedData['sku'] = $this->generateSKU($validatedData['name']);

    $product = Products::create($validatedData);
return redirect()->route('products.index')->with('success', 'Product added successfully!');
}


private function generateSKU($productName)
{
    $namePart = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $productName), 0, 3));
    $randomNumber = mt_rand(1000, 9999);
    return $namePart . '-' . $randomNumber;
}


    public function edit(Products $product)
    {
        $categories = Categories::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Products $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'visibility' => 'required|boolean',
            'stock' => 'required|integer',
            'tax_rate' => 'nullable|numeric',
            'hsn_code' => 'nullable|string|max:255',
        ]);

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Products $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
