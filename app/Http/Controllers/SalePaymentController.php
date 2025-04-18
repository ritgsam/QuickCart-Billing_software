<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalePayment;
use App\Models\SaleInvoice;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class SalePaymentController extends Controller
{

public function index()
{
    $payments = SalePayment::with('saleInvoice')->get();
    return view('sale_payments.index', compact('payments'));
}
public function create()
{
    $customers = Customer::all();
$invoices = SaleInvoice::with('customer')->get();
    return view('sale_payments.create', compact('customers', 'invoices'));
}
public function edit($id)
{
    $salePayment = SalePayment::findOrFail($id);
    $invoices = SaleInvoice::all();

    return view('sale_payments.edit', compact('salePayment', 'invoices'));
}

public function store(Request $request)
{
// dd($request->total_invoice_amount);
    $request->validate([
        'sale_invoice_id' => 'required|exists:sale_invoices,id',
        'amount_paid' => 'required|numeric|min:0.01',
        'payment_date' => 'required|date',
        'payment_method' => 'required|string',
        'transaction_id' => 'nullable|string',
        'payment_mode' => 'nullable|string',
    ]);

    $saleInvoice = SaleInvoice::with('customer')->findOrFail($request->sale_invoice_id);

    $actualAmount = $saleInvoice->final_amount ?? 0;

    if ($actualAmount <= 0) {
        return back()->withErrors(['sale_invoice_id' => 'Invoice has no valid final amount.']);
    }

    $roundedAmount = round($actualAmount);
    $roundOff = round($roundedAmount - $actualAmount, 2);

    $totalPaid = SalePayment::where('sale_invoice_id', $saleInvoice->id)->sum('amount_paid');

    $newPaidTotal = $totalPaid + $request->amount_paid;

    $newBalanceDue = $actualAmount - $newPaidTotal;
    $newBalanceDue = max($newBalanceDue, 0);

    if ($newBalanceDue < 0) {
        $saleInvoice->final_amount = $newPaidTotal;
        $newBalanceDue = 0;
    }

    $salePayment = SalePayment::create([
        'sale_invoice_id' => $saleInvoice->id,
        'customer_id'     => $saleInvoice->customer_id,
        'amount_paid'     => $request->amount_paid,
        'payment_date'    => $request->payment_date,
        'payment_method'  => $request->payment_method,
        'transaction_id'  => $request->transaction_id,
        'payment_mode'    => $request->payment_mode ?? 'Cash',
        'balance_due'     => $newBalanceDue,
        'round_off'       => $roundOff,
    ]);

    $saleInvoice->balance_due = $newBalanceDue;
    $saleInvoice->payment_status = $newBalanceDue <= 0 ? 'Paid' : 'Partially Paid';
    $saleInvoice->save();

    return redirect()->route('sale_payments.index')->with('success', 'Payment added and invoice updated successfully!');
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

public function getInvoiceDetails($id)
{
    $invoice = \App\Models\SaleInvoice::with('customer')->find($id);

    if (!$invoice) {
        return response()->json(['error' => 'Invoice not found'], 404);
    }

    return response()->json([
        'customer_id'    => $invoice->customer->id ?? '',
        'customer_name'  => $invoice->customer->name ?? '',
        'payment_status' => $invoice->payment_status ?? '',
        'payment_mode'   => $invoice->payment_mode ?? '',
        'total_amount'   => number_format((float)$invoice->final_amount, 2, '.', ''),
        'balance_due'    => number_format((float)$invoice->final_amount, 2, '.', ''),
    ]);
}

    public function destroy($id)
    {
        $salePayment = SalePayment::findOrFail($id);
        $salePayment->delete();

        return redirect()->route('sale-payments.index')->with('success', 'Sale Payment Deleted Successfully');
    }
};
