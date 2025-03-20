@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Invoice #{{ $invoice->invoice_number }}</h1>

    <p><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
    <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
    <p><strong>Payment Status:</strong> {{ $invoice->payment_status }}</p>
    <p><strong>Total Amount:</strong> ₹{{ number_format($invoice->total_amount, 2) }}</p>

    <h2 class="text-xl font-bold mt-4">Invoice Items</h2>
    <table class="w-full border mt-2 bg-white">
        <thead>
            <tr class="bg-gray-200">
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Tax (%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                <td>{{ $item->tax }}%</td>
                <td>₹{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
<br>
    <a href="{{ route('sale_invoices.index') }}" class="bg-gray-500 text-white px-4 py-2 mt-4 rounded">Back to Invoices</a>
</div>
@endsection
