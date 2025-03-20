<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalePayment;
use App\Models\SaleInvoice;
use App\Models\Customer;

class SalePaymentController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'sale_invoice_id' => 'required|exists:sale_invoices,id',
        'customer_id' => 'required|exists:customers,id',
        'payment_date' => 'required|date',
        'amount_paid' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'gst' => 'nullable|numeric|min:0|max:100',
        'payment_mode' => 'required|string',
        'payment_method' => 'required|string',
    ]);

    SalePayment::create([
        'sale_invoice_id' => $request->sale_invoice_id,
        'customer_id' => $request->customer_id,
        'payment_date' => $request->payment_date,
        'amount_paid' => $request->amount_paid,
        'discount' => $request->discount ?? 0,
        'gst' => $request->gst ?? 0,
        'round_off' => $request->round_off ?? 0,
        'balance_due' => $request->balance_due,
        'payment_mode' => $request->payment_mode,
        'payment_method' => $request->payment_method,
        'transaction_id' => $request->transaction_id ?? null,
        'status' => $request->status ?? 'Pending',
    ]);

    return redirect()->route('sale_payments.index')->with('success', 'Payment recorded successfully!');
}
public function index()
{
    $payments = SalePayment::with('saleInvoice')->get();
    return view('sale_payments.index', compact('payments'));
}
// public function index()
// {
//     $payments = SalePayment::with('saleInvoice')->get();
//     $invoices = SaleInvoice::all();

//     return view('sale_payments.index', compact('payments', 'invoices'));
// }


public function edit($id)
{
    $salePayment = SalePayment::findOrFail($id);
    $invoices = SaleInvoice::all();

    return view('sale_payments.edit', compact('salePayment', 'invoices'));
}

public function create()
{
    $invoices = SaleInvoice::with('customer')->get();
    $customers = Customer::all();

    return view('sale_payments.create', compact('invoices', 'customers'));
}

public function update(Request $request, SalePayment $salePayment)
{
    $validatedData = $request->validate([
        'amount_paid' => 'required|numeric|min:0',
        'payment_mode' => 'required|string',
        'transaction_id' => 'nullable|string',
        'status' => 'required|string'
    ]);

    $salePayment->update($validatedData);

    return redirect()->route('sale-payments.index')->with('success', 'Payment updated successfully!');
}


    public function destroy($id)
    {
        $salePayment = SalePayment::findOrFail($id);
        $salePayment->delete();

        return redirect()->route('sale-payments.index')->with('success', 'Sale Payment Deleted Successfully');
    }
};

