<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
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



    public function edit(Customer $customer)
{
    return view('customers.edit', compact('customer'));
}

    public function create()
    {
        return view('customers.create');
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
    ]);

    Customer::create($request->all());

    return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
}

}
