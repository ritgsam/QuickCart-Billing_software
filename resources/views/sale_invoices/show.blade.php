@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header text-white" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Invoice #{{ $invoice->invoice_number }}</h4>
        </div>
        <div class="card-body" style="background-color: #f5ebe0;">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
                    <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Payment Status:</strong> <span class="badge bg-primary">{{ $invoice->payment_status }}</span></p>
                    <p><strong>Total Amount:</strong> ₹{{ number_format($invoice->total_amount, 2) }}</p>
                </div>
            </div>

@if($invoice->transportation)
    <h4 class="mt-4">Transportation Details</h4>
    <ul>
        <li><strong>Transporter:</strong> {{ $invoice->transportation->transporter_name }}</li>
        <li><strong>Vehicle:</strong> {{ $invoice->transportation->vehicle_number }}</li>
        <li><strong>Dispatch Date:</strong> {{ $invoice->transportation->dispatch_date }}</li>
        <li><strong>Expected Delivery:</strong> {{ $invoice->transportation->expected_delivery_date }}</li>
        <li><strong>Status:</strong> {{ $invoice->transportation->status }}</li>
    </ul>
@endif

            <h5 class="mt-4">Invoice Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered mt-2 bg-white">
                
<thead class="table-dark">
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>SGST (%)</th>
        <th>CGST (%)</th>
        <th>IGST (%)</th>
        <th>Total</th>
    </tr>
</thead>
<tbody>
    @foreach ($invoice->items as $item)
    <tr>
        <td>{{ $item->product->name }}</td>
        <td>{{ $item->quantity }}</td>
        <td>₹{{ number_format($item->unit_price, 2) }}</td>
        <td>{{ $item->sgst }}%</td>
        <td>{{ $item->cgst }}%</td>
        <td>{{ $item->igst }}%</td>
        <td>₹{{ number_format($item->total_price, 2) }}</td>
    </tr>
    @endforeach
</tbody>

                </table>
<div class="mt-3">
    <p><strong>Subtotal (Before Round Off):</strong> ₹{{ number_format($invoice->total_amount, 2) }}</p>
    <p><strong>Round Off:</strong> ₹{{ number_format($invoice->round_off, 2) }}</p>
    <p><strong>Final Amount (After Round Off):</strong> ₹{{ number_format($invoice->final_amount, 2) }}</p>
</div>

            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('sale_invoices.index') }}" class="btn btn-secondary">Back to Invoices</a>
            </div>
        </div>
    </div>
</div>
@endsection
