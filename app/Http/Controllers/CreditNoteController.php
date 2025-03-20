<?php
namespace App\Http\Controllers;

use App\Models\CreditNote;
use App\Models\SaleInvoice;
use App\Models\Customer;
use Illuminate\Http\Request;

class CreditNoteController extends Controller
{
    public function index()
    {
        $creditNotes = CreditNote::with('saleInvoice', 'customer')->get();
        return view('credit_notes.index', compact('creditNotes'));
    }

    public function create()
    {
        $customers = Customer::all();
        $saleInvoices = SaleInvoice::all();
        return view('credit_notes.create', compact('customers', 'saleInvoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_invoice_id' => 'required|exists:sale_invoices,id',
            'credit_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'reason' => 'nullable|string|max:255',
        ]);

        $saleInvoice = SaleInvoice::findOrFail($request->sale_invoice_id);
        $customer_id = $saleInvoice->customer_id;

        CreditNote::create([
            'sale_invoice_id' => $request->sale_invoice_id,
            'customer_id' => $customer_id,
            'credit_date' => $request->credit_date,
            'actual_amount' => $request->total_amount,
            'tax_amount' => 0,
            'round_off' => 0,
            'total_amount' => $request->total_amount,
            'reason' => $request->reason,
        ]);

        return redirect()->route('credit_notes.index')->with('success', 'Credit Note Created Successfully!');
    }

    public function show(CreditNote $creditNote)
    {
        return view('credit_notes.show', compact('creditNote'));
    }

    public function edit(CreditNote $creditNote)
    {
        $customers = Customer::all();
        $saleInvoices = SaleInvoice::all();
        return view('credit_notes.edit', compact('creditNote', 'saleInvoices', 'customers'));
    }

    public function update(Request $request, CreditNote $creditNote)
    {
        $request->validate([
            'sale_invoice_id' => 'required|exists:sale_invoices,id',
            'credit_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'reason' => 'nullable|string|max:255',
        ]);

        $creditNote->update($request->all());

        return redirect()->route('credit_notes.index')->with('success', 'Credit Note Updated Successfully!');
    }

    public function destroy(CreditNote $creditNote)
    {
        $creditNote->delete();
        return redirect()->route('credit_notes.index')->with('success', 'Credit Note Deleted.');
    }
}

