<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Products;
use App\Models\SalePayment;
use App\Models\SaleInvoiceItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class SaleInvoiceController extends Controller
{
public function index(Request $request)
{
    $query = SaleInvoice::with('customer', 'items');

    if ($request->filled('search_invoice')) {
        $query->where('invoice_number', 'like', '%' . $request->search_invoice . '%');
    }

    if ($request->filled('customer_id')) {
        $query->where('customer_id', $request->customer_id);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
    }

    if ($request->filled('payment_status')) {
        $query->where('payment_status', $request->payment_status);
    }

    $saleInvoices = $query->orderBy('invoice_date', 'desc')->paginate(10);

    $customers = Customer::all();

    return view('sale_invoices.index', compact('saleInvoices', 'customers'));
}

public function download($id)
{
    $invoice = SaleInvoice::findOrFail($id);

    $pdf = Pdf::loadView('sale_invoices.pdf', compact('invoice'));

    return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
}


public function generatePdf($id)
{
    $invoice = SaleInvoice::with(['customer', 'items.product'])->findOrFail($id);

    $pdf = Pdf::loadView('sale_invoices.pdf', compact('invoice'))
                ->setPaper('A4', 'portrait');

    return $pdf->stream("Sale_Invoice_{$invoice->invoice_number}.pdf");
}


public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}
public function update(Request $request, SaleInvoice $invoice)
{
    $request->validate([
        'customer_id' => 'required',
        'invoice_date' => 'required|date',
        'payment_status' => 'required',
        'due_date' => 'nullable|date',
        'round_off' => 'nullable|numeric',
        'global_discount' => 'nullable|numeric',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|numeric|min:1',
        'products.*.unit_price' => 'required|numeric|min:0',
        'products.*.gst_rate' => 'required|numeric',
        'products.*.discount' => 'nullable|numeric|min:0',
        'products.*.total_price' => 'required|numeric|min:0',
    ]);

    $invoice->update([
        'customer_id' => $request->customer_id,
        'invoice_date' => $request->invoice_date,
        'payment_status' => $request->payment_status,
        'due_date' => $request->due_date,
        'round_off' => $request->round_off ?? 0,
        'global_discount' => $request->global_discount ?? 0,
    ]);

    SaleInvoiceItem::where('sale_invoice_id', $invoice->id)->delete();

    foreach ($request->products as $product) {
        SaleInvoiceItem::create([
            'sale_invoice_id' => $invoice->id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'unit_price' => $product['unit_price'],
            'gst_rate' => $product['gst_rate'],
            'discount' => $product['discount'] ?? 0,
            'total_price' => $product['total_price'],
        ]);
    }

    $this->updatePaymentStatus($invoice);

    return redirect()->route('sale_invoices.index')->with('success', 'Invoice updated successfully');
}
private function updatePaymentStatus(SaleInvoice $invoice)
{
    $totalPaid = SalePayment::where('sale_invoice_id', $invoice->id)->sum('amount_paid');

    if ($totalPaid >= $invoice->total_amount) {
        $invoice->update(['payment_status' => 'Paid']);
    } elseif ($totalPaid > 0) {
        $invoice->update(['payment_status' => 'Partial']);
    } else {
        $invoice->update(['payment_status' => 'Unpaid']);
    }
}

public function edit($id)
{
    $invoice = SaleInvoice::findOrFail($id);
    $customers = Customer::all();
    $products = Products::all();
    $invoiceItems = SaleInvoiceItem::where('sale_invoice_id', $id)->get();

    return view('sale_invoices.edit', compact('invoice', 'customers', 'products', 'invoiceItems'));
}

    public function pay($id)
{
    $invoice = SaleInvoice::findOrFail($id);
    return view('sale_invoices.pay', compact('invoice'));
}

public function storePayment(Request $request, $id)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0',
        'round_off' => 'required|numeric',
        'payment_method' => 'required|string',
    ]);

    $invoice = SaleInvoice::findOrFail($id);

    SalePayment::create([
        'sale_invoice_id' => $invoice->id,
        'amount' => $validated['amount'],
        'round_off' => $validated['round_off'],
        'payment_method' => $validated['payment_method'],
        'payment_date' => now(),
        'status' => ($invoice->balance_due <= $validated['amount'] + $validated['round_off']) ? 'Paid' : 'Partial',


    ]);

    if ($invoice->balance_due <= 0) {
        $invoice->update(['payment_status' => 'Paid']);
    } else {
        $invoice->update(['payment_status' => 'Partial']);
    }

    return redirect()->route('sale_invoices.index')->with('success', 'Payment added successfully!');
}


public function create()
{
    $customers = Customer::all();
    $products = Products::all();
    return view('sale_invoices.create', compact('customers', 'products'));
}


public function show($id)
{
    $invoice = SaleInvoice::with('customer', 'items.product')->findOrFail($id);
    return view('sale_invoices.show', compact('invoice'));
}
public function store(Request $request)
{
    $invoice = SaleInvoice::create([
        'customer_id' => $request->customer_id,
        'invoice_date' => $request->invoice_date,
        'payment_status' => $request->payment_status,
        'due_date' => $request->due_date,
        'round_off' => $request->round_off ?? 0,
        'global_discount' => $request->global_discount ?? 0,
        'total_amount' => 0,
    ]);

    $totalAmount = 0;

    foreach ($request->products as $product) {
        $subtotal = $product['quantity'] * $product['unit_price'];
        $discountAmount = ($subtotal * $product['discount']) / 100;
        $gstAmount = (($subtotal - $discountAmount) * $product['gst_rate']) / 100;
        $totalPrice = $subtotal - $discountAmount + $gstAmount;

        SaleInvoiceItem::create([
            'sale_invoice_id' => $invoice->id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'unit_price' => $product['unit_price'],
            'gst_rate' => $product['gst_rate'],
            'discount' => $product['discount'] ?? 0,
            'total_price' => $totalPrice,
        ]);

        $totalAmount += $totalPrice;
    }

    $invoice->update(['total_amount' => $totalAmount]);

    return redirect()->route('sale_invoices.index')->with('success', 'Invoice created successfully.');
}
    public function destroy(SaleInvoice $saleInvoice)
    {
        $saleInvoice->delete();
        return redirect()->route('sale_invoices.index')->with('success', 'Invoice deleted successfully!');
    }
}
