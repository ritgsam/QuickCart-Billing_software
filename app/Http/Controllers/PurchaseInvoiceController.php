<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Supplier;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use App\Libraries\PurchaseInvoicePDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PurchaseInvoiceController extends Controller
{
public function index(Request $request)
{
    $query = PurchaseInvoice::with(['supplier', 'items', 'payments']);

    if ($request->has('supplier_id') && $request->supplier_id) {
        $query->where('supplier_id', $request->supplier_id);
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

    return view('purchase_invoices.index', [
        'invoices' => $invoices,
        'suppliers' => Supplier::all()
    ]);
}

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
        'round_off' => 'nullable|numeric',
        'global_discount' => 'nullable|numeric|min:0',
        'invoice_notes' => 'nullable|string',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.unit_price' => 'required|numeric|min:0',
        'products.*.gst_rate' => 'required|numeric|min:0',
        'products.*.discount' => 'nullable|numeric|min:0',
    ]);

    $invoice = PurchaseInvoice::findOrFail($id);

    $invoice->update([
        'supplier_id' => $validated['supplier_id'],
        'invoice_date' => $validated['invoice_date'],
        'due_date' => $validated['due_date'],
        'invoice_notes' => $validated['invoice_notes'],
        'round_off' => $validated['round_off'] ?? 0,
        'global_discount' => $validated['global_discount'] ?? 0,
    ]);

    $invoice->items()->delete();

    $subtotalAmount = 0;
    $totalDiscount = 0;
    $totalGst = 0;

    foreach ($validated['products'] as $product) {
        $subtotal = $product['quantity'] * $product['unit_price'];
        $discountAmount = ($subtotal * ($product['discount'] ?? 0)) / 100;
        $subtotalAfterDiscount = $subtotal - $discountAmount;

        $gstAmount = ($subtotalAfterDiscount * $product['gst_rate']) / 100;
        $totalPrice = $subtotalAfterDiscount + $gstAmount;

        PurchaseInvoiceItem::create([
            'purchase_invoice_id' => $invoice->id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'unit_price' => $product['unit_price'],
            'gst_rate' => $product['gst_rate'],
            'discount' => $product['discount'] ?? 0,
            'discount_amount' => $discountAmount,
            'gst_amount' => $gstAmount,
            'total_price' => $totalPrice,
        ]);

        $subtotalAmount += $subtotal;
        $totalDiscount += $discountAmount;
        $totalGst += $gstAmount;
    }

    $globalDiscountAmount = ($subtotalAmount * $invoice->global_discount) / 100;
    $totalAmountAfterDiscount = $subtotalAmount - $totalDiscount - $globalDiscountAmount;

    $finalGst = ($totalAmountAfterDiscount * $totalGst) / $subtotalAmount;
    $finalAmount = $totalAmountAfterDiscount + $finalGst + $invoice->round_off;

    $paidAmount = $invoice->payments()->sum('amount');
    if ($paidAmount >= $finalAmount) {
        $paymentStatus = 'Paid';
    } elseif ($paidAmount > 0) {
        $paymentStatus = 'Partial';
    } else {
        $paymentStatus = 'Unpaid';
    }

    $invoice->update([
        'total_amount' => $subtotalAmount,
        'discount_total' => $totalDiscount + $globalDiscountAmount,
        'gst_total' => $finalGst,
        'final_amount' => $finalAmount,
        'payment_status' => $paymentStatus,
    ]);

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
    $validatedData = $request->validate([
        'supplier_id'    => 'required|exists:suppliers,id',
        'invoice_date'   => 'required|date',
        'due_date'       => 'nullable|date',
        'global_discount' => 'nullable|numeric',
        'round_off'      => 'nullable|numeric',
        'invoice_notes'  => 'nullable|string',
        'products'       => 'required|array|min:1', 
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity'   => 'required|numeric|min:1',
        'products.*.unit_price' => 'required|numeric|min:0',
        'products.*.gst_rate'   => 'nullable|numeric|min:0',
        'products.*.discount'   => 'nullable|numeric|min:0',
        'products.*.total_price' => 'required|numeric|min:0',
    ]);

    try {
        DB::beginTransaction();

        $invoiceNumber = 'INV-' . str_pad(PurchaseInvoice::count() + 1, 4, '0', STR_PAD_LEFT);

        $invoice = PurchaseInvoice::create([
            'supplier_id'    => $validatedData['supplier_id'],
            'invoice_number' => $invoiceNumber,
            'invoice_date'   => $validatedData['invoice_date'],
            'due_date'       => $validatedData['due_date'] ?? null,
            'discount_total' => $validatedData['global_discount'] ?? 0,
            'round_off'      => $validatedData['round_off'] ?? 0,
            'invoice_notes'  => $validatedData['invoice_notes'] ?? null,
            'final_amount'   => 0, 
            'total_amount'   => 0, 
            'payment_status' => 'Unpaid',
        ]);

        $totalAmount = 0;
        $gstTotal = 0;
        $discountTotal = 0;

        foreach ($validatedData['products'] as $product) {
            $subtotal = ($product['unit_price'] * $product['quantity']); 
            $discount = ($subtotal * ($product['discount'] / 100));
            $tax = (($subtotal - $discount) * ($product['gst_rate'] / 100));
            $total = $subtotal - $discount + $tax;

            PurchaseInvoiceItem::create([
                'purchase_invoice_id' => $invoice->id,
                'product_id'   => $product['product_id'],
                'quantity'     => $product['quantity'],
                'unit_price'   => $product['unit_price'],
                'gst_rate'     => $product['gst_rate'],
                'discount'     => $product['discount'],
                'total_price'  => $total,
            ]);

            $totalAmount += $total;
            $gstTotal += $tax;
            $discountTotal += $discount;
        }
$finalAmount = round($totalAmount, 2);
$roundOff = round($finalAmount) - $finalAmount; 

$invoice->update([
    'total_amount'   => $totalAmount,
    'gst_total'      => $gstTotal,
    'discount_total' => $discountTotal,
    'round_off'      => $roundOff,
    'final_amount'   => $finalAmount + $roundOff,
]);
       

        DB::commit(); 
        return redirect()->route('purchase_invoices.index')->with('success', 'Purchase Invoice created successfully.');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error($e->getMessage()); 
        return back()->withErrors(['error' => 'Error saving invoice: ' . $e->getMessage()]);
    }
}
public function generatePdf($id)
{
    $invoice = PurchaseInvoice::with(['supplier', 'items.product'])->findOrFail($id);

    $pdf = new PurchaseInvoicePDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, "PURCHASE INVOICE", 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 8, "Invoice Number: " . $invoice->invoice_number, 0, 0, 'L');
    $pdf->Cell(95, 8, "Invoice Date: " . $invoice->invoice_date, 0, 1, 'R');
    $pdf->Cell(95, 8, "Supplier: " . $invoice->supplier->company_name, 0, 1, 'L');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->Cell(60, 10, 'Product', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Qty', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Unit Price', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'GST (%)', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Discount %', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Total', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 9);
    foreach ($invoice->items as $item) {
        $pdf->Cell(60, 8, $item->product->name, 1);
        $pdf->Cell(20, 8, $item->quantity, 1, 0, 'C');
        $pdf->Cell(30, 8, utf8_decode("") . number_format($item->unit_price, 2), 1, 0, 'R');
        $pdf->Cell(20, 8, $item->gst_rate . '%', 1, 0, 'C');
        $pdf->Cell(20, 8, $item->discount . '%', 1, 0, 'C');
        $pdf->Cell(30, 8, utf8_decode("") . number_format($item->total_price, 2), 1, 1, 'R');
    }

    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total Amount:', 0, 0, 'R');
    $pdf->Cell(30, 10, utf8_decode("") . number_format($invoice->total_amount, 2), 0, 1, 'R');

    $pdf->Output('D', "Purchase_Invoice_{$invoice->invoice_number}.pdf");
}
}
