@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Make Payment</h1>

    <form action="{{ route('sale_invoices.pay', $invoice->id) }}" method="POST">
        @csrf

        <label>Amount:</label>
        <input type="number" name="amount" required>

        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select>

        <button type="submit">Submit Payment</button>
    </form>
</div>
@endsection
