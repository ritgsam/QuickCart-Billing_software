@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Purchase Payment</h2>
<form action="{{ route('purchase_payments.update', $purchasePayment->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="purchase_invoice_id">Select Invoice:</label>
    <select name="purchase_invoice_id" class="form-control">
        <option value="">Select Invoice</option>
        @foreach ($invoices as $invoice)
            <option value="{{ $invoice->id }}" {{ $purchasePayment->purchase_invoice_id == $invoice->id ? 'selected' : '' }}>
                {{ $invoice->invoice_number }}
            </option>
        @endforeach
    </select>
    <label>Payment Date:</label>
    <input type="date" name="payment_date" value="{{ $purchasePayment->payment_date }}" class="form-control">

    <label>Amount Paid (₹):</label>
    <input type="number" name="amount_paid" value="{{ $purchasePayment->amount_paid }}" class="form-control">

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
</form>
</div>
@endsection
