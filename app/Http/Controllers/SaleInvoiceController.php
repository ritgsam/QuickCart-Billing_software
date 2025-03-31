<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Products;
use App\Models\SalePayment;
use App\Models\SaleInvoiceItem;
use Illuminate\Support\Facades\DB;
use App\Libraries\MyFPDF;
// index,create,store,show,update,destroy
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


public function generatePdf($id)
{
    $invoice = SaleInvoice::with(['customer', 'items.product'])->findOrFail($id);

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
    $pdf->Cell(60, 8, 'Product', 1, 0, 'C', true);
    $pdf->Cell(15, 8, 'Qty', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Unit Price', 1, 0, 'C', true);
    $pdf->Cell(20, 8, 'GST (%)', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'Discount (%)', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Total', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 9);
    foreach ($invoice->items as $item) {
        $pdf->Cell(60, 8, $item->product->name, 1, 0, 'L');
        $pdf->Cell(15, 8, $item->quantity, 1, 0, 'C');
        $pdf->Cell(30, 8, utf8_decode("") . number_format($item->unit_price, 2), 1, 0, 'R');
        $pdf->Cell(20, 8, $item->gst_rate . '%', 1, 0, 'C');
        $pdf->Cell(25, 8, $item->discount . '%', 1, 0, 'C');
        $pdf->Cell(40, 8, utf8_decode("") . number_format($item->total_price, 2), 1, 1, 'R');
    }

    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(145, 10, 'Total Amount:', 0, 0, 'R');
    $pdf->Cell(40, 10, utf8_decode("") . number_format($invoice->total_amount, 2), 0, 1, 'R');

    $pdf->Output('D', "Invoice_{$invoice->invoice_number}.pdf");
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
    $validatedData = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'payment_status' => 'required|string',
        'invoice_date' => 'required|date',
        'due_date' => 'required|date',
        'round_off' => 'nullable|numeric',
        'global_discount' => 'nullable|numeric',
        'final_amount' => 'required|numeric|min:0',
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|numeric|min:1',
        'products.*.unit_price' => 'required|numeric|min:0.01',
        'products.*.gst_rate' => 'required|numeric|min:0',
        'products.*.discount' => 'nullable|numeric|min:0',
    ]);

    try {
        DB::beginTransaction();

        $invoice = SaleInvoice::create([
            'customer_id' => $validatedData['customer_id'],
            'invoice_date' => $validatedData['invoice_date'],
            'payment_status' => $validatedData['payment_status'],
            'due_date' => $validatedData['due_date'],
            'round_off' => $validatedData['round_off'] ?? 0,
            'global_discount' => $validatedData['global_discount'] ?? 0,
            'total_amount' => 0,
        ]);

        $totalAmount = 0;

        foreach ($validatedData['products'] as $product) {
            $subtotal = $product['quantity'] * $product['unit_price'];
            $discountAmount = ($subtotal * ($product['discount'] ?? 0)) / 100;
            $subtotalAfterDiscount = $subtotal - $discountAmount;
            $gstAmount = ($subtotalAfterDiscount * $product['gst_rate']) / 100;
            $totalPrice = $subtotalAfterDiscount + $gstAmount;

            $totalAmount += $totalPrice;

            SaleInvoiceItem::create([
                'sale_invoice_id' => $invoice->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'unit_price' => $product['unit_price'],
                'gst_rate' => $product['gst_rate'],
                'discount' => $product['discount'] ?? 0,
                'total_price' => $totalPrice,
            ]);
        }

        $discountAmount = ($totalAmount * ($validatedData['global_discount'] ?? 0)) / 100;
        $finalAmount = $totalAmount - $discountAmount;

        $roundedAmount = round($finalAmount, 0);
        $roundOff = number_format($roundedAmount - $finalAmount, 2, '.', '');

        $invoice->update([
            'total_amount' => $roundedAmount,
            'round_off' => $roundOff,
        ]);

        DB::commit();

        return redirect()->route('sale_invoices.index')->with('success', 'Invoice created successfully.');

    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()->with('error', 'Error creating invoice: ' . $e->getMessage());
    }
}
    public function destroy(SaleInvoice $saleInvoice)
    {
        $saleInvoice->delete();
        return redirect()->route('sale_invoices.index')->with('success', 'Invoice deleted successfully!');
    }
}
