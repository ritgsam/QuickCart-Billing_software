<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalePayment;
use App\Models\SaleInvoiceItem;
use Illuminate\Support\Facades\DB;
use App\Libraries\MyFPDF;
use Illuminate\Support\Facades\Log;
use App\Models\Transportation;


class SaleInvoiceController extends Controller
{

public function index(Request $request)
{
    $query = SaleInvoice::with(['customer', 'items', 'payments']);

    if ($request->has('customer_id') && $request->customer_id) {
        $query->where('customer_id', $request->customer_id);
    }

    if ($request->has('payment_status') && $request->payment_status) {
        $query->where('payment_status', $request->payment_status);
    }

    if ($request->has('start_date') && $request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->has('end_date') && $request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->has('search') && $request->search) {
        $query->where('invoice_number', 'LIKE', '%' . $request->search . '%');
    }

    $invoices = $query->paginate(10);
    $customers = Customer::all();

    return view('sale_invoices.index', compact('invoices', 'customers'));
}
public function create()
{
    $customers = Customer::with('country')->get();
    $products = Product::with(['prices.country'])->get();

    return view('sale_invoices.create', compact('customers', 'products'));
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
    $products = Product::all();
    $invoiceItems = SaleInvoiceItem::where('sale_invoice_id', $id)->get();

    return view('sale_invoices.edit', compact('invoice', 'customers', 'products', 'invoiceItems'));
}
    public function pay($id)
{
    $invoice = SaleInvoice::findOrFail($id);
    return view('sale_invoices.pay', compact('invoice'));
}
public function store(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'invoice_date' => 'required|date',
        'due_date' => 'nullable|date',
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|numeric|min:1',
        'products.*.unit_price' => 'required|numeric|min:0',
        'products.*.sgst' => 'nullable|numeric|min:0',
        'products.*.cgst' => 'nullable|numeric|min:0',
        'products.*.igst' => 'nullable|numeric|min:0',
        'products.*.discount' => 'nullable|numeric|min:0',

        'transporter_name' => 'nullable|string|max:255',
        'vehicle_number' => 'nullable|string|max:50',
        'dispatch_date' => 'nullable|date',
        'expected_delivery_date' => 'nullable|date',
        'status' => 'nullable|string|max:50',
    ]);

    $saleInvoice = SaleInvoice::create([
        'customer_id' => $request->customer_id,
        'invoice_date' => $request->invoice_date,
        'due_date' => $request->due_date,
        'global_discount' => $request->global_discount ?? 0,
        'invoice_notes' => $request->invoice_notes ?? '',
        'round_off' => 0,
        'final_amount' => 0,
        'payment_status' => $request->payment_status ?? 'Unpaid',
        'total_amount' => 0,
    ]);

    $totalAmount = 0;

    foreach ($request->products as $product) {
        $quantity = $product['quantity'];
        $unitPrice = $product['unit_price'];
        $discount = $product['discount'] ?? 0;
        $sgst = $product['sgst'] ?? 0;
        $cgst = $product['cgst'] ?? 0;
        $igst = $product['igst'] ?? 0;

        $base = $quantity * $unitPrice;
        $discountAmount = ($base * $discount) / 100;
        $afterDiscount = $base - $discountAmount;

        $sgstAmount = ($afterDiscount * $sgst) / 100;
        $cgstAmount = ($afterDiscount * $cgst) / 100;
        $igstAmount = ($afterDiscount * $igst) / 100;

        $total = $afterDiscount + $sgstAmount + $cgstAmount + $igstAmount;

        SaleInvoiceItem::create([
            'sale_invoice_id' => $saleInvoice->id,
            'product_id' => $product['product_id'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'sgst' => $sgst,
            'cgst' => $cgst,
            'igst' => $igst,
            'discount' => $discount,
            'total_price' => $total,
        ]);

        $totalAmount += $total;
    }

    $discountedAmount = $totalAmount;
    if ($request->global_discount) {
        $discountedAmount -= ($totalAmount * $request->global_discount / 100);
    }

    $rounded = round($discountedAmount);
    $roundOff = round($rounded - $discountedAmount, 2);

    $saleInvoice->update([
        'total_amount' => $totalAmount,
        'round_off' => $roundOff,
        'final_amount' => $rounded,
    ]);

    Transportation::create([
        'sale_invoice_id' => $saleInvoice->id,
        'transporter_name' => $request->transporter_name,
        'vehicle_number' => $request->vehicle_number,
        'dispatch_date' => $request->dispatch_date,
        'expected_delivery_date' => $request->expected_delivery_date,
        'status' => $request->status ?? 'Pending',
    ]);

    return redirect()->route('sale_invoices.index')->with('success', 'Invoice created successfully!');
}
public function storePayment(Request $request, $id)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0',
        'round_off' => 'required|numeric',
        'payment_method' => 'required|string',
    ]);

    $invoice = SaleInvoice::findOrFail($id);

$totalPaid = SalePayment::where('sale_invoice_id', $invoice->id)->sum('amount_paid') + $validated['amount'];
$balance = $invoice->total_amount - $totalPaid;

SalePayment::create([
    'sale_invoice_id' => $invoice->id,
    'amount_paid' => $validated['amount'],
    'round_off' => $validated['round_off'],
    'payment_method' => $validated['payment_method'],
    'payment_date' => now(),
    'status' => $balance <= 0 ? 'Paid' : 'Partial',
]);

$invoice->update([
    'payment_status' => $balance <= 0 ? 'Paid' : 'Partial',
]);

    return redirect()->route('sale_invoices.index')->with('success', 'Payment added successfully!');
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

    $totalSubtotal = 0;
    $totalGST = 0;
    $totalDiscount = 0;

    foreach ($request->products as $product) {
        $subtotal = $product['quantity'] * $product['unit_price'];
        $discountAmount = ($subtotal * $product['discount']) / 100;
        $subtotalAfterDiscount = $subtotal - $discountAmount;
        $gstAmount = ($subtotalAfterDiscount * $product['gst_rate']) / 100;
        $totalPrice = $subtotalAfterDiscount + $gstAmount;

        SaleInvoiceItem::create([
            'sale_invoice_id' => $invoice->id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'unit_price' => $product['unit_price'],
            'gst_rate' => $product['gst_rate'],
            'discount' => $product['discount'] ?? 0,
            'total_price' => $totalPrice,
        ]);

        $totalSubtotal += $subtotal;
        $totalDiscount += $discountAmount;
        $totalGST += $gstAmount;
    }

    $globalDiscountAmount = ($totalSubtotal * $request->global_discount) / 100;
    $subtotalAfterGlobalDiscount = $totalSubtotal - $globalDiscountAmount;

    $globalGST = ($subtotalAfterGlobalDiscount * $totalGST) / $totalSubtotal;

    $finalTotal = $subtotalAfterGlobalDiscount + $globalGST + $request->round_off;

    $invoice->update([
        'total_amount' => $finalTotal,
        'global_gst' => $globalGST,
    ]);

    return redirect()->route('sale_invoices.index')->with('success', 'Invoice updated successfully.');
}

public function show($id)
{
    $invoice = SaleInvoice::with('customer', 'items.product')->findOrFail($id);
    return view('sale_invoices.show', compact('invoice'));
}

public function generatePdf($id)
{
    $invoice = SaleInvoice::with(['customer', 'items.product', 'transportation'])->findOrFail($id);

    $pdf = new MyFPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 8, "Invoice Number: " . $invoice->invoice_number, 0, 0, 'L');
    $pdf->Cell(95, 8, "Invoice Date: " . $invoice->invoice_date, 0, 1, 'R');
    $pdf->Cell(95, 8, "Customer: " . $invoice->customer->name, 0, 0, 'L');
    $pdf->Cell(95, 8, "Due Date: " . $invoice->due_date, 0, 1, 'R');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->Cell(40, 8, 'Product', 1, 0, 'C', true);
    $pdf->Cell(10, 8, 'Qty', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'Unit Price', 1, 0, 'C', true);
    $pdf->Cell(15, 8, 'SGST', 1, 0, 'C', true);
    $pdf->Cell(15, 8, 'CGST', 1, 0, 'C', true);
    $pdf->Cell(15, 8, 'IGST', 1, 0, 'C', true);
    $pdf->Cell(20, 8, 'Discount', 1, 0, 'C', true);
    $pdf->Cell(45, 8, 'Total Price', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 9);
    foreach ($invoice->items as $item) {
        $pdf->Cell(40, 8, $item->product->name, 1, 0, 'L');
        $pdf->Cell(10, 8, $item->quantity, 1, 0, 'C');
        $pdf->Cell(25, 8, number_format($item->unit_price, 2), 1, 0, 'R');
        $pdf->Cell(15, 8, $item->sgst . '%', 1, 0, 'C');
        $pdf->Cell(15, 8, $item->cgst . '%', 1, 0, 'C');
        $pdf->Cell(15, 8, $item->igst . '%', 1, 0, 'C');
        $pdf->Cell(20, 8, $item->discount . '%', 1, 0, 'C');
        $pdf->Cell(45, 8, number_format($item->total_price, 2), 1, 1, 'R');
    }

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(145, 8, 'Final Amount:', 0, 0, 'R');
    $pdf->Cell(45, 8, number_format($invoice->final_amount, 2), 0, 1, 'R');

if ($invoice->transportation) {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, 'Transportation Details:', 0, 1);

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(95, 8, "Transporter: " . $invoice->transportation->transporter_name, 0, 0);
    $pdf->Cell(95, 8, "Vehicle No: " . $invoice->transportation->vehicle_number, 0, 1);
    $pdf->Cell(95, 8, "Dispatch Date: " . $invoice->transportation->dispatch_date, 0, 0);
    $pdf->Cell(95, 8, "Expected Delivery: " . $invoice->transportation->expected_delivery_date, 0, 1);
    $pdf->Cell(0, 8, "Status: " . $invoice->transportation->status, 0, 1);
}

    $pdf->Output('D', "Invoice_{$invoice->invoice_number}.pdf");
}

public function destroy(SaleInvoice $saleInvoice)
    {
        $saleInvoice->delete();
        return redirect()->route('sale_invoices.index')->with('success', 'Invoice deleted successfully!');
    }
}
