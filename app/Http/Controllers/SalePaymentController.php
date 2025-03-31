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
    $invoices = SaleInvoice::all();
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
    $request->validate([
        'sale_invoice_id' => 'required|exists:sale_invoices,id',
        'amount_paid' => 'required|numeric|min:0.01',
        'payment_date' => 'required|date',
        'payment_method' => 'required|string',
        'transaction_id' => 'nullable|string',
    ]);

    $saleInvoice = SaleInvoice::findOrFail($request->sale_invoice_id);
    $actualAmount = floatval($saleInvoice->final_amount);

    $roundedAmount = round($actualAmount, 0);
    $roundOff = round($roundedAmount - $actualAmount, 2);

    $totalPaid = SalePayment::where('sale_invoice_id', $saleInvoice->id)->sum('amount_paid');
    $newBalanceDue = $actualAmount - ($totalPaid + $request->amount_paid + $roundOff);

    $newBalanceDue = max($newBalanceDue, 0);

    $salePayment = SalePayment::create([
        'sale_invoice_id' => $saleInvoice->id,
        'customer_id' => $saleInvoice->customer_id,
        'amount_paid' => $request->amount_paid,
        'payment_date' => $request->payment_date,
        'payment_method' => $request->payment_method,
        'transaction_id' => $request->transaction_id ?? null,
        'payment_mode' => $request->payment_mode ?? 'Cash',
        'round_off' => $roundOff,
        'balance_due' => $newBalanceDue,
    ]);

    return redirect()->route('sale_payments.index')->with('success', 'Payment Added Successfully!');
}
public function getInvoiceDetails($invoiceId)
{
    $invoice = SaleInvoice::with(['customer', 'items', 'payments'])->findOrFail($invoiceId);

    $totalPaid = $invoice->payments->sum('amount_paid');
    $balanceDue = max($invoice->total_amount - $totalPaid, 0);
    $roundOff = round($invoice->total_amount) - $invoice->total_amount;

    return response()->json([
        'customer_id' => $invoice->customer->id ?? null,
        'customer_name' => $invoice->customer->name ?? 'No Customer',
        'payment_status' => $invoice->payment_status ?? 'Unpaid',
        'payment_mode' => $invoice->payment_mode ?? 'Cash',
        'total_amount' => round($invoice->total_amount, 2),
        'balance_due' => round($balanceDue, precision: 2),
        'round_off' => round($roundOff, 2),
    ]);
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

