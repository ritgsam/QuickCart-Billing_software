<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

public function create()
    {
        return view('customers.create');
    }

public function getCountry($id)
{
    $customer = Customer::find($id);
    return response()->json(['country' => $customer->country]);
}
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers',
        'phone' => 'required|string|max:15',
        'address' => 'nullable|string',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:10',
        'gst_number' => 'nullable|string|max:20',
        'country' => 'nullable|max:100',

    ]);

    Customer::create($request->all());

    return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
}

   public function edit(Customer $customer)
{
    return view('customers.edit', compact('customer'));
}


public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers,email,' . $id,
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:500',

    ]);

    $customer = Customer::findOrFail($id);
    $customer->update($validated);

    return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
}

public function getPricesByCustomer($customerId)
{
    $customer = Customer::findOrFail($customerId);
    $countryId = $customer->country_id;

    if (!$countryId) {
        return response()->json(['error' => 'Customer has no country assigned'], 422);
    }

    $products = Product::with(['prices' => function ($query) use ($countryId) {
        $query->where('country_id', $countryId);
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

 public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
