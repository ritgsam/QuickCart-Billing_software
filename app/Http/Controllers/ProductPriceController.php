<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductPrice;

class ProductPriceController extends Controller
{

public function getPricesByCustomer($customerId)
{
    $customer = Customer::findOrFail($customerId);
    $countryId = $customer->country_id;

    if (!$countryId) {
        return response()->json(['error' => 'Customer has no country assigned'], 422);
    }

    $products = Product::with(['prices' => function ($q) use ($countryId) {
        $q->where('country_id', $countryId);
    }])->get();

    $productList = $products->map(function ($product) {
        $price = $product->prices->first();
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $price ? $price->price : 0,
        ];
    });

    return response()->json(['products' => $productList]);
}
public function getCountryPrices(Customer $customer)
{
    $countryId = $customer->country_id;

    $products = Product::with(['prices' => function($q) use ($countryId) {
        $q->where('country_id', $countryId);
    }])->get();

    $productList = [];

    foreach ($products as $product) {
        $price = $product->prices->first();
        if ($price) {
            $productList[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price->price,
            ];
        }
    }

    return response()->json(['products' => $productList]);
}

}
