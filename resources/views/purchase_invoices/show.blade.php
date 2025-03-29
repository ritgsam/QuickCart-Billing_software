@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Purchase Invoice Details</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border p-4 bg-gray-50 rounded-lg">
            <p><span class="font-semibold text-gray-700">Invoice Number:</span> {{ $invoice->invoice_number }}</p>
            <p><span class="font-semibold text-gray-700">Supplier:</span> {{ $invoice->supplier->company_name }}</p>
            <p><span class="font-semibold text-gray-700">Invoice Date:</span> {{ $invoice->invoice_date }}</p>
            <p><span class="font-semibold text-gray-700">Due Date:</span> {{ $invoice->due_date ?? 'N/A' }}</p>
            <p><span class="font-semibold text-gray-700">Payment Status:</span>
                <span class="px-2 py-1 rounded
                {{ $invoice->payment_status == 'Paid' ? 'bg-green-100 text-green-700' : ($invoice->payment_status == 'Unpaid' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ $invoice->payment_status }}
                </span>
            </p>
            <p><span class="font-semibold text-gray-700">Invoice Notes:</span> {{ $invoice->invoice_notes ?? 'N/A' }}</p>
            <p><span class="font-semibold text-gray-700">Total Amount:</span> ₹{{ number_format($invoice->total_amount, 2) }}</p>
            <p><span class="font-semibold text-gray-700">Round Off:</span> ₹{{ number_format($invoice->round_off, 2) }}</p>
            <p class="col-span-2"><span class="font-semibold text-gray-700">Final Amount:</span> <span class="text-lg font-bold text-blue-700">₹{{ number_format($invoice->final_amount, 2) }}</span></p>
        </div>

        <h2 class="text-2xl font-bold mt-6 text-gray-800">Invoice Items</h2>
        <div class="overflow-x-auto mt-4">
            <table class="w-full border-collapse bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-700 text-white">
                        <th class="px-4 py-3 border">Product</th>
                        <th class="px-4 py-3 border">Quantity</th>
                        <th class="px-4 py-3 border">Unit Price</th>
                        <th class="px-4 py-3 border">Tax (%)</th>
                        <th class="px-4 py-3 border">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                    <tr class="border {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="px-4 py-2 border">{{ $item->product->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 border">₹{{ number_format($item->unit_price, 2) }}</td>
<td class="px-4 py-2 border">
    {{ isset($item->tax) ? number_format($item->gst_rate, 2) : 'N/A' }}%
</td>
                        <td class="px-4 py-2 border">₹{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-start">
            <a href="{{ route('purchase_invoices.index') }}" class="bg-gray-700 text-white px-5 py-2 rounded-lg hover:bg-gray-900 transition">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection
