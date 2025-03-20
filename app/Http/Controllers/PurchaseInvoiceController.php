<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Products;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseInvoiceController extends Controller
{
   public function index(Request $request)
{
    $query = PurchaseInvoice::with('supplier');

    if ($request->has('start_date') && $request->start_date) {
        $query->whereDate('invoice_date', '>=', $request->start_date);
    }

    if ($request->has('end_date') && $request->end_date) {
        $query->whereDate('invoice_date', '<=', $request->end_date);
    }

    if ($request->has('supplier_id') && $request->supplier_id) {
        $query->where('supplier_id', $request->supplier_id);
    }

    if ($request->has('payment_status') && $request->payment_status) {
        $query->where('payment_status', $request->payment_status);
    }

    if ($request->has('search') && $request->search) {
        $query->where('invoice_number', 'LIKE', '%' . $request->search . '%');
    }

    $invoices = $query->orderBy('invoice_date', 'desc')->paginate(10);

    $suppliers = Supplier::all();

    return view('purchase_invoices.index', compact('invoices', 'suppliers'));
}


public function pdf($id)
{
    $invoice = PurchaseInvoice::with('supplier', 'items.product')->findOrFail($id);

    $pdf = Pdf::loadView('purchase_invoices.pdf', compact('invoice'));

    return $pdf->download('purchase_invoice_' . $id . '.pdf');
}

// public function generatePdf($id)
// {
//     $invoice = PurchaseInvoice::with(['supplier', 'items.product'])->findOrFail($id);

//     $pdf = Pdf::loadView('purchase_invoices.pdf', compact('invoice'))
//                 ->setPaper('A4', 'portrait');

//     return $pdf->stream("Purchase_Invoice_{$invoice->invoice_number}.pdf");
// }

public function show($id)
{
    $invoice = PurchaseInvoice::with('supplier', 'items.product')->findOrFail($id);
    return view('purchase_invoices.show', compact('invoice'));
}

public function edit($id)
{
    $invoice = PurchaseInvoice::with('items.product')->findOrFail($id);
    $suppliers = Supplier::all();
    $products = Products::all();
    return view('purchase_invoices.edit', compact('invoice', 'suppliers', 'products'));
}


    public function create()
    {
        $suppliers = Supplier::all();
        $products = Products::all();
        return view('purchase_invoices.create', compact('suppliers', 'products'));
    }

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'invoice_date' => 'required|date',
        'payment_status' => 'required|in:Paid,Unpaid,Partial',
        'due_date' => 'nullable|date',
        'invoice_notes' => 'nullable|string',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.unit_price' => 'required|numeric|min:0',
        'products.*.tax' => 'nullable|numeric|min:0',
    ]);

    $invoice = PurchaseInvoice::findOrFail($id);
    $invoice->update([
        'supplier_id' => $validated['supplier_id'],
        'invoice_date' => $validated['invoice_date'],
        'payment_status' => $validated['payment_status'],
        'due_date' => $validated['due_date'],
        'invoice_notes' => $validated['invoice_notes'],
    ]);

    $invoice->items()->delete();

    foreach ($validated['products'] as $product) {
        PurchaseInvoiceItem::create([
            'purchase_invoice_id' => $invoice->id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'unit_price' => $product['unit_price'],
            'tax' => $product['tax'],
            'total_price' => ($product['quantity'] * $product['unit_price']) + (($product['quantity'] * $product['unit_price']) * ($product['tax'] / 100))
        ]);
    }

    return redirect()->route('purchase_invoices.index')->with('success', 'Purchase Invoice updated successfully!');
}
public function destroy($id)
{
    $invoice = PurchaseInvoice::findOrFail($id);

    $invoice->items()->delete();

    $invoice->delete();

    return redirect()->route('purchase_invoices.index')->with('success', 'Purchase Invoice deleted successfully!');
}
public function store(Request $request)
{
    $invoice = PurchaseInvoice::create([
        'supplier_id' => $request->supplier_id,
        'invoice_date' => $request->invoice_date,
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

        PurchaseInvoiceItem::create([
            'purchase_invoice_id' => $invoice->id,
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

    return redirect()->route('purchase_invoices.index')->with('success', 'Invoice created successfully.');
}

}
