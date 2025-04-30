<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use App\Models\SaleInvoice;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function index()
    {
        $transportations = Transportation::with('saleInvoice.customer')->latest()->get();
        return view('transportation.index', compact('transportations'));
    }
public function create()
    {
        $saleInvoices = SaleInvoice::with('customer')->get();
        return view('transportation.create', compact('saleInvoices'));
    }
    public function show($id)
    {
        $transportation = Transportation::with('saleInvoice.customer')->findOrFail($id);
        return view('transportation.show', compact('transportation'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_invoice_id' => 'required|exists:sale_invoices,id',
            'transporter_name' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:100',
            'dispatch_date' => 'required|date',
            'expected_delivery_date' => 'required|date|after_or_equal:dispatch_date',
            'status' => 'required|string|max:50',
        ]);

        Transportation::create($validated);
        return redirect()->route('transportation.index')->with('success', 'Transportation added.');
    }
public function destroy($id)
{
    $transportation = Transportation::findOrFail($id);
    $transportation->delete();

    return redirect()->route('transportation.index')->with('success', 'Transportation record deleted successfully.');
}


}

