
@extends('layouts.app')
@php
    $purchasePayment = $purchasePayment ?? new \App\Models\PurchasePayment();
@endphp

@section('content')
<div class="container p-4">
    <h1 class="text-center fw-bold mb-4">Add Purchase Payment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{-- <form action="{{ route('purchase_payments.store') }}" method="POST">
    @csrf

    <label for="purchase_invoice_id">Select Invoice</label>
    <select name="purchase_invoice_id" class="form-control" required>
        <option value="">Select Invoice</option>
        @foreach ($invoices as $invoice)
            <option value="{{ $invoice->id }}" data-supplier="{{ $invoice->supplier_id }}">
                {{ $invoice->invoice_number }}
            </option>
        @endforeach
    </select>

    <label for="supplier_id">Select Supplier</label>
    <select name="supplier_id" class="form-control" required>
        <option value="">Select Supplier</option>
        @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
        @endforeach
    </select> --}}


{{-- <form action="{{ route('purchase_payments.store') }}" method="POST">
    @csrf

    <label for="purchase_invoice_id">Select Invoice:</label>
    <select name="purchase_invoice_id" class="form-control" required>
        <option value="">Select Invoice</option>
        @foreach ($invoices as $invoice)
            <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</option>
        @endforeach
    </select> --}}

{{-- <form action="{{ route('purchase-payments.update', $purchasePayment->id) }}" method="POST"> --}}

{{-- <form action="{{ route('purchase-payments.store') }}" method="POST">
    @csrf
    @method('PUT')

    <label for="purchase_invoice_id">Select Invoice</label>
    <select name="purchase_invoice_id" class="form-control">
        <option value="">Select Invoice</option>
        @foreach ($invoices as $invoice)
            <option value="{{ $invoice->id }}" {{ $purchasePayment->purchase_invoice_id == $invoice->id ? 'selected' : '' }}>
                {{ $invoice->invoice_number }}
            </option>
        @endforeach
    </select> --}}

    {{-- <label>Payment Date:</label>
    <input type="date" name="payment_date" value="{{ $purchasePayment->payment_date }}" class="form-control">

    <label>Amount Paid (₹):</label>
    <input type="number" name="amount_paid" value="{{ old('amount_paid') }}" class="form-control">

    <label>Discount (₹):</label>
    <input type="number" name="discount" value="{{ $purchasePayment->discount }}" class="form-control">

    <label>GST (%) :</label>
    <input type="number" name="gst" value="{{ $purchasePayment->gst }}" class="form-control">

    <label>Round Off (₹):</label>
    <input type="number" name="round_off" value="{{ $purchasePayment->round_off }}" class="form-control">

    <label>Balance Due (₹):</label>
    <input type="number" name="balance_due" value="{{ $purchasePayment->balance_due }}" class="form-control">

    <label>Payment Mode:</label>
    <select name="payment_mode" class="form-control">
        <option value="Cash" {{ $purchasePayment->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
        <option value="Card" {{ $purchasePayment->payment_mode == 'Card' ? 'selected' : '' }}>Card</option>
        <option value="UPI" {{ $purchasePayment->payment_mode == 'UPI' ? 'selected' : '' }}>UPI</option>
        <option value="Bank Transfer" {{ $purchasePayment->payment_mode == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
    </select>

    <label>Status:</label>
    <select name="status" class="form-control">
        <option value="Completed" {{ $purchasePayment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
        <option value="Pending" {{ $purchasePayment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
    </select>

    <button type="submit" class="btn btn-primary">Update Payment</button>
</form> --}}
    <form method="POST" action="{{ route('purchase-payments.store') }}">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Select Invoice:</label>
                <select name="purchase_invoice_id" class="form-select" required>
                    <option value="">-- Select Invoice --</option>
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Select Supplier:</label>
                <select name="supplier_id" class="form-select" required>
                    <option value="">-- Select Supplier --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Payment Date:</label>
                <input type="date" name="payment_date" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Amount Paid (₹):</label>
                <input type="number" step="0.01" name="amount_paid" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Round Off (₹):</label>
                <input type="number" step="0.01" name="round_off" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Balance Due (₹):</label>
                <input type="number" step="0.01" name="balance_due" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Payment Mode:</label>
                <select name="payment_mode" class="form-select" required>
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                    <option value="UPI">UPI</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Transaction ID (Optional):</label>
                <input type="text" name="transaction_id" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Payment Status:</label>
                <select name="status" class="form-select" required>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Save Payment</button>
        </div>
    </form>
</div>
@endsection
