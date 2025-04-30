<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\SaleInvoice;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Libraries\PurchaseInvoicePDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyFPDF;

class PurchaseInvoiceController extends Controller
{

public function index(Request $request)
{
    $query = PurchaseInvoice::with(['supplier', 'items']);

    if ($request->filled('supplier_id')) {
        $query->where('supplier_id', $request->supplier_id);
    }


    if ($request->filled('payment_status')) {
        $query->where('payment_status', $request->payment_status);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('invoice_date', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('invoice_date', '<=', $request->end_date);
    }

    if ($request->filled('search')) {
        $query->where('invoice_number', 'LIKE', '%' . $request->search . '%');
    }

    $invoices = $query->paginate(10);
    $suppliers = Supplier::all();

    return view('purchase_invoices.index', compact('invoices', 'suppliers'));
}

public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchase_invoices.create', compact('suppliers', 'products'));
    }

public function show($id)
{
    $invoice = PurchaseInvoice::with('supplier', 'items.product')->findOrFail($id);
    return view('purchase_invoices.show', compact('invoice'));
}

public function store(Request $request)
{

    $validated = $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'invoice_date' => 'required|date',
        'due_date' => 'nullable|date',
        'invoice_notes' => 'nullable|string',
        'global_discount' => 'nullable|numeric|min:0',
        'round_off' => 'nullable|numeric',
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|numeric|min:1',
        'products.*.unit_price' => 'required|numeric|min:0',
        'products.*.discount' => 'nullable|numeric|min:0',
        'products.*.sgst' => 'nullable|numeric|min:0',
        'products.*.cgst' => 'nullable|numeric|min:0',
        'products.*.igst' => 'nullable|numeric|min:0',

        'transporter_name' => 'nullable|string|max:255',
        'vehicle_number' => 'nullable|string|max:100',
        'dispatch_date' => 'nullable|date',
        'expected_delivery_date' => 'nullable|date',
        'status' => 'nullable|string|max:50',
    ]);

    try {
        DB::beginTransaction();

        $invoiceNumber = 'INV-' . str_pad(PurchaseInvoice::count() + 1, 4, '0', STR_PAD_LEFT);

        $invoice = PurchaseInvoice::create([
            'supplier_id' => $validated['supplier_id'],
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'] ?? null,
            'invoice_notes' => $validated['invoice_notes'] ?? '',
            'discount_total' => 0,
            'sgst_total' => 0,
            'cgst_total' => 0,
            'igst_total' => 0,
            'total_amount' => 0,
            'round_off' => 0,
            'final_amount' => 0,
            'payment_status' => 'paid',
        ]);

        $totalAmount = 0;
        $discountTotal = 0;
        $sgstTotal = 0;
        $cgstTotal = 0;
        $igstTotal = 0;

        foreach ($validated['products'] as $productData) {
            $quantity = $productData['quantity'];
            $unitPrice = $productData['unit_price'];
            $discount = $productData['discount'] ?? 0;
            $sgst = $productData['sgst'] ?? 0;
            $cgst = $productData['cgst'] ?? 0;
            $igst = $productData['igst'] ?? 0;

            $subtotal = $quantity * $unitPrice;
            $discountAmount = ($subtotal * $discount) / 100;
            $subtotalAfterDiscount = $subtotal - $discountAmount;

            $sgstAmount = ($subtotalAfterDiscount * $sgst) / 100;
            $cgstAmount = ($subtotalAfterDiscount * $cgst) / 100;
            $igstAmount = ($subtotalAfterDiscount * $igst) / 100;

            $totalPrice = $subtotalAfterDiscount + $sgstAmount + $cgstAmount + $igstAmount;

            PurchaseInvoiceItem::create([
                'purchase_invoice_id' => $invoice->id,
                'product_id' => $productData['product_id'],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'discount' => $discount,
                'sgst' => $sgst,
                'cgst' => $cgst,
                'igst' => $igst,
                'total_price' => $totalPrice,
            ]);

            $totalAmount += $totalPrice;
            $discountTotal += $discountAmount;
            $sgstTotal += $sgstAmount;
            $cgstTotal += $cgstAmount;
            $igstTotal += $igstAmount;
        }

        $rounded = round($totalAmount);
        $roundOff = round($rounded - $totalAmount, 2);

        $invoice->update([
            'total_amount' => $totalAmount,
            'discount_total' => $discountTotal,
            'sgst_total' => $sgst,
            'cgst_total' => $cgst,
            'igst_total' => $igst,
            'round_off' => $roundOff,
            'final_amount' => $totalAmount + $roundOff,
        ]);

$invoice->transportation()->updateOrCreate([], [
    'transporter_name' => $validated['transporter_name'] ?? null,
    'vehicle_number' => $validated['vehicle_number'] ?? null,
    'dispatch_date' => $validated['dispatch_date'] ?? null,
    'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
    'status' => $validated['status'] ?? 'Pending',
]);


        DB::commit();
        return redirect()->route('purchase_invoices.index')->with('success', 'Purchase Invoice created successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('PurchaseInvoiceStoreError', ['error' => $e->getMessage()]);
        return back()->withErrors(['error' => 'Failed to create invoice: ' . $e->getMessage()]);
    }
}

public function edit($id)
{
    $invoice = PurchaseInvoice::with('items.product')->findOrFail($id);
    $suppliers = Supplier::all();
    $products = Product::all();
    return view('purchase_invoices.edit', compact('invoice', 'suppliers', 'products'));
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

    'transporter_name' => 'nullable|string|max:255',
    'vehicle_number' => 'nullable|string|max:100',
    'dispatch_date' => 'nullable|date',
    'expected_delivery_date' => 'nullable|date',
    'status' => 'nullable|string|max:50',

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

$invoice->transportation()->updateOrCreate([], [
    'transporter_name' => $validated['transporter_name'] ?? null,
    'vehicle_number' => $validated['vehicle_number'] ?? null,
    'dispatch_date' => $validated['dispatch_date'] ?? null,
    'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
    'status' => $validated['status'] ?? 'Pending',
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
public function generatePdf($id)
    {
        $invoice = PurchaseInvoice::with(['supplier', 'items.product'])->findOrFail($id);

        $pdf = new MyFPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(95, 8, "Invoice Number: " . $invoice->invoice_number, 0, 0, 'L');
        $pdf->Cell(95, 8, "Invoice Date: " . $invoice->invoice_date, 0, 1, 'R');
        $pdf->Cell(95, 8, "Supplier: " . $invoice->supplier->company_name, 0, 0, 'L');
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

        $pdf->Output('D', "Purchase_Invoice_{$invoice->invoice_number}.pdf");
    }
}
