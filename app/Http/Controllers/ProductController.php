<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TaxRate;
use App\Models\Country;
use App\Models\ProductCountryPrice;
use App\Models\CountryPrice;
use App\Models\Customer;
use App\Models\ProductPrice;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with('category')
            ->when(request('category_id'), function($query) {
                $query->where('category_id', request('category_id'));
            })
            ->latest()
            ->paginate(10);

        $categories = Categories::all();

        return view('products.index', compact('products', 'categories'));
    }

public function create()
{
    $categories = Categories::all();
    $countries = Country::all();

    return view('products.create', compact('categories', 'countries'));
}
public function edit($id)
{
    $product = Product::with('prices')->findOrFail($id);
    $categories = Categories::all();
    $countries = Country::all();

    return view('products.edit', compact('product', 'categories', 'countries'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
        'gst_rate' => 'nullable|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'visibility' => 'required|boolean',
        'hsn_code' => 'nullable|string|max:15',
        'prices' => 'nullable|array|min:1',
        'prices.*.country_id' => 'required|exists:countries,id',
        'prices.*.price' => 'required|numeric|min:0',
    ]);

    $product = Product::create([
        'name' => $validated['name'],
        'sku' => 'SKU-' . strtoupper(uniqid()),
        'purchase_price' => $validated['purchase_price'],
        'selling_price' => $validated['selling_price'],
        'category_id' => $validated['category_id'],
        'stock' => $validated['stock'],
        'gst_rate' => $validated['gst_rate'] ?? 0,
        'discount' => $validated['discount'] ?? 0,
        'visibility' => $validated['visibility'],
        'hsn_code' => $validated['hsn_code'],
    ]);

foreach ($request->country_prices as $entry) {
    ProductPrice::create([
        'product_id' => $product->id,
        'country_id' => $entry['country_id'],
        'price' => $entry['price'],
    ]);
}

    return redirect()->route('products.index')->with('success', 'Product created with country-wise prices.');
}

public function getCountryPrice(Request $request)
{
    $productId = $request->product_id;
    $country = $request->country;

    $price = ProductPrice::where('product_id', $productId)
                ->where('country', $country)
                ->first();

    return response()->json(['price' => $price ? $price->price : 0]);
}


public function getProductsByCustomerCountry($customerId)
{
    $customer = Customer::findOrFail($customerId);

    $products = Products::with(['prices' => function ($query) use ($customer) {
        $query->where('country_id', $customer->country_id);
    }])->get();

    $productList = $products->map(function ($product) {
        $price = $product->prices->first();
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $price ? $price->price : 0
        ];
    });

    return response()->json($productList);
}


public function update(Request $request, Product $product)
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

foreach ($request->prices as $priceData) {
    if (!empty($priceData['price'])) {
        ProductPrice::updateOrCreate(
            [
                'product_id' => $product->id,
                'country_id' => $priceData['country_id']
            ],
            [
                'price' => $priceData['price']
            ]
        );
    }
}
    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}

public function destroy(Product $product)
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
