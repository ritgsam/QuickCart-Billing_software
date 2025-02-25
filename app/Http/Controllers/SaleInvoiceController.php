<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SaleInvoice;

class SaleInvoiceController extends Controller {
    public function index() {
        return response()->json(SaleInvoice::with('customer')->get());
    }

    public function store(Request $request) {
        $invoice = SaleInvoice::create($request->all());
        return response()->json($invoice);
    }

    public function show($id) {
        return response()->json(SaleInvoice::with('customer', 'saleInvoiceItems')->findOrFail($id));
    }

    public function update(Request $request, $id) {
        $invoice = SaleInvoice::findOrFail($id);
        $invoice->update($request->all());
        return response()->json($invoice);
    }

    public function destroy($id) {
        SaleInvoice::findOrFail($id)->delete();
        return response()->json(['message' => 'Invoice deleted']);
    }

}
