@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Purchase Invoice Details</h1>

    <div class="border p-4 bg-white rounded-lg">
        <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Supplier:</strong> {{ $invoice->supplier->company_name }}</p>
        <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
        <p><strong>Due Date:</strong> {{ $invoice->due_date ?? 'N/A' }}</p>
        <p><strong>Payment Status:</strong> {{ $invoice->payment_status }}</p>
        <p><strong>Invoice Notes:</strong> {{ $invoice->invoice_notes ?? 'N/A' }}</p>
        <p><strong>Total Amount:</strong> ₹{{ number_format($invoice->total_amount, 2) }}</p>
        <p><strong>Round Off:</strong> ₹{{ number_format($invoice->round_off, 2) }}</p>
        <p><strong>Final Amount:</strong> ₹{{ number_format($invoice->final_amount, 2) }}</p>
    </div>

    <h2 class="text-2xl font-bold mt-6">Invoice Items</h2>
    <table class="w-full mt-4 border bg-white">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border">Product</th>
                <th class="px-4 py-2 border">Quantity</th>
                <th class="px-4 py-2 border">Unit Price</th>
                <th class="px-4 py-2 border">Tax (%)</th>
                <th class="px-4 py-2 border">Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
            <tr class="border">
                <td class="px-4 py-2 border">{{ $item->product->name ?? 'N/A' }}</td>
                <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                <td class="px-4 py-2 border">₹{{ number_format($item->unit_price, 2) }}</td>
                <td class="px-4 py-2 border">{{ $item->tax }}%</td>
                <td class="px-4 py-2 border">₹{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('purchase_invoices.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Back to List</a>
</div>
@endsection
