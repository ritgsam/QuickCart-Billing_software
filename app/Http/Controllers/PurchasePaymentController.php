<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchasePayment;
use App\Models\PurchaseInvoice;
use App\Models\Supplier;

class PurchasePaymentController extends Controller {
public function index()
{
    $purchasePayments = PurchasePayment::with(['purchaseInvoice.supplier'])->get(); // ✅ Ensure invoice and supplier are fetched
    return view('purchase_payments.index', compact('purchasePayments'));
}


public function create()
{
    $suppliers = Supplier::all();
    $invoices = PurchaseInvoice::all();
    return view('purchase_payments.create', compact('suppliers', 'invoices'));
}



    public function store(Request $request)
{
    $request->validate([
        'purchase_invoice_id' => 'required|exists:purchase_invoices,id',
        'supplier_id' => 'required|exists:suppliers,id',
        'amount_paid' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'gst' => 'nullable|numeric|min:0',
        'round_off' => 'nullable|numeric|min:0',
        'balance_due' => 'required|numeric|min:0',
        'payment_mode' => 'required|string',
        'status' => 'required|string',
    ]);

    PurchasePayment::create([
        'purchase_invoice_id' => $request->purchase_invoice_id,
        'supplier_id' => $request->supplier_id,
        'payment_date' => $request->payment_date ?? now(),
        'amount_paid' => $request->amount_paid,
        'discount' => $request->discount ?? 0,
        'gst' => $request->gst ?? 0,
        'round_off' => $request->round_off ?? 0,
        'balance_due' => $request->balance_due,
        'payment_mode' => $request->payment_mode,
        'status' => $request->status,
    ]);

    return redirect()->route('purchase_payments.index')->with('success', 'Payment recorded successfully!');
}

public function edit($id)
{
    $purchasePayment = PurchasePayment::findOrFail($id);
    $invoices = PurchaseInvoice::all();
    return view('purchase_payments.edit', compact('purchasePayment', 'invoices'));
}

public function update(Request $request, PurchasePayment $purchasePayment)
{
    $request->validate([
        'amount_paid' => 'required|numeric|min:0',
        'gst' => 'nullable|numeric|min:0|max:100',
        'discount' => 'nullable|numeric|min:0|max:100',
        'payment_mode' => 'required|string',
        'status' => 'required|string'
    ]);

    $purchasePayment->update([
        'amount_paid' => $request->amount_paid,
        'gst' => $request->gst ?? 0,
        'discount' => $request->discount ?? 0,
        'payment_mode' => $request->payment_mode,
        'status' => $request->status
    ]);

    return redirect()->route('purchase_payments.index')->with('success', 'Payment updated successfully!');
}

   public function destroy($id)
    {
        $purchasePayment = PurchasePayment::findOrFail($id);
        $purchasePayment->delete();

        return redirect()->route('purchase_payments.index')->with('success', 'Payment deleted successfully!');
    }

};

