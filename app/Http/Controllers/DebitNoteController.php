<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DebitNote;
use App\Models\Supplier;
use App\Models\PurchaseInvoice;

class DebitNoteController extends Controller
{
    public function index()
{
    $debitNotes = DebitNote::with(['supplier', 'purchaseInvoice'])->get();
    return view('debit_notes.index', compact('debitNotes'));
}
    public function create()
    {
        $suppliers = Supplier::all();
        $purchaseInvoices = PurchaseInvoice::all();
        return view('debit_notes.create', compact('suppliers', 'purchaseInvoices'));
    }
    public function store(Request $request)
{
    $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'purchase_invoice_id' => 'required|exists:purchase_invoices,id',
        'debit_date' => 'required|date',
        'total_amount' => 'required|numeric',
    ]);

    $latestDebitNote = DebitNote::latest()->first();
    $nextNumber = $latestDebitNote ? ($latestDebitNote->id + 1) : 1;
    $debitNoteNumber = 'DN-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

    $debitNote = DebitNote::create([
        'debit_note_number' => $debitNoteNumber,
        'supplier_id' => $request->supplier_id,
        'purchase_invoice_id' => $request->purchase_invoice_id,
        'debit_date' => $request->debit_date,
        'total_amount' => $request->total_amount,
    ]);

    return redirect()->route('debit_notes.index')->with('success', 'Debit Note Created!');
}
public function edit($id)
{
    $debitNote = DebitNote::findOrFail($id);
    $suppliers = Supplier::all();
    $purchaseInvoices = PurchaseInvoice::all();

    return view('debit_notes.edit', compact('debitNote', 'suppliers', 'purchaseInvoices'));
}

public function getSupplierInvoice($supplierId)
{
    $invoice = PurchaseInvoice::where('supplier_id', $supplierId)
                ->latest()
                ->first(['id', 'invoice_number']);

    if ($invoice) {
        return response()->json(['invoice' => $invoice]);
    }

    return response()->json(['invoice' => null]);
}
    public function destroy(DebitNote $debitNote)
    {
        $debitNote->delete();

        return redirect()->route('debit_notes.index')->with('success', 'Debit Note Deleted Successfully!');
    }
}
