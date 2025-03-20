@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Edit Sale Payment</h1>

    <form action="{{ route('sale-payments.update', $salePayment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="sale_invoice_id">Select Invoice</label>
<select name="sale_invoice_id" id="sale_invoice_id" class="form-control" required>
    <option value="">Select Invoice</option>
    @foreach ($invoices as $invoice)
        <option value="{{ $invoice->id }}" {{ $salePayment->sale_invoice_id == $invoice->id ? 'selected' : '' }}>
            {{ $invoice->invoice_number }}
        </option>
    @endforeach
</select>



        <label>Payment Date:</label>
        <input type="date" name="payment_date" value="{{ $salePayment->payment_date }}" class="w-full p-2 border rounded">

        <label>Amount Paid (₹):</label>
        <input type="number" name="amount_paid" value="{{ $salePayment->amount_paid }}" class="w-full p-2 border rounded">

        <label>Round Off (₹):</label>
        <input type="number" name="round_off" value="{{ $salePayment->round_off }}" class="w-full p-2 border rounded">

        <label>Balance Due (₹):</label>
        <input type="number" name="balance_due" value="{{ $salePayment->balance_due }}" class="w-full p-2 border rounded">

        <label>Payment Mode:</label>
        <select name="payment_mode" class="w-full p-2 border rounded">
            <option value="Cash" {{ $salePayment->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
            <option value="Card" {{ $salePayment->payment_mode == 'Card' ? 'selected' : '' }}>Card</option>
            <option value="UPI" {{ $salePayment->payment_mode == 'UPI' ? 'selected' : '' }}>UPI</option>
            <option value="Bank Transfer" {{ $salePayment->payment_mode == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
        </select>

        <label>Status:</label>
        <select name="status" class="w-full p-2 border rounded">
            <option value="Completed" {{ $salePayment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            <option value="Pending" {{ $salePayment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
        </select>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update Payment</button>
    </form>
</div>
@endsection
