<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'company_name' => 'required|string|max:255',
        'email' => 'required|email|unique:suppliers',
        'phone' => 'required|string|max:15',
        'address' => 'nullable|string',
        'gst_number' => 'nullable|string|max:20',
        'payment_terms' => 'nullable|string|max:50',
    ]);

    Supplier::create($request->all());

    return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully.');
}


    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
{
    $request->validate([
        'company_name' => 'required|string|max:255',
        'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
        'phone' => 'required|string|max:15',
        'address' => 'nullable|string',
        'gst_number' => 'nullable|string|max:20',
        'payment_terms' => 'nullable|string|max:100',
    ]);

    $supplier->update($request->all());

    return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
}


    public function destroy(Supplier $supplier)
{
    $supplier->delete();
    return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
}

}
