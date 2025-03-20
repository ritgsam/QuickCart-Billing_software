@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Record Sale Payment</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sale_payments.store') }}" method="POST" class="bg-white p-6 shadow rounded">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div class="form-group">
<label for="sale_invoice_id">Select Invoice</label>
<select name="sale_invoice_id" id="sale_invoice_id" class="form-control" required>
    <option value="">-- Select Invoice --</option>
    @foreach ($invoices as $invoice)
        <option value="{{ $invoice->id }}">
            {{ $invoice->invoice_number }} - {{ $invoice->customer->name ?? 'No Customer' }}
        </option>
    @endforeach
</select>
</div>

            <div>
                <label class="block font-semibold">Customer:</label>
                <select name="customer_id" class="w-full p-2 border rounded" required>
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold">Payment Date:</label>
                <input type="date" name="payment_date" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Amount Paid (₹):</label>
                <input type="number" step="0.01" name="amount_paid" class="w-full p-2 border rounded" required>
            </div>
<div>
                <label class="block font-semibold">Round Off (₹):</label>
                <input type="number" step="0.01" name="round_off" class="w-full p-2 border rounded">
            </div>
            <div>
                <label class="block font-semibold">Balance Due (₹):</label>
                <input type="number" step="0.01" name="balance_due" class="w-full p-2 border rounded" required>
            </div>
<div class="mb-3">
    <label for="discount" class="form-label">Discount (₹)</label>
    <input type="number" class="form-control" name="discount" step="0.01" value="0">
</div>

<div class="mb-3">
    <label for="gst" class="form-label">GST (%)</label>
    <input type="number" class="form-control" name="gst" step="0.01" value="0">
</div>


            <div>
                <label class="block font-semibold">Payment Mode:</label>
                <select name="payment_mode" class="w-full p-2 border rounded" required>
                    <option value="">Select Payment Mode</option>
                    <option value="Online">Online</option>
                    <option value="Offline">Offline</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold">Payment Method:</label>
                <select name="payment_method" class="w-full p-2 border rounded" required>
                    <option value="">Select Payment Method</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="UPI">UPI</option>
                    <option value="PayPal">PayPal</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold">Transaction ID (Optional):</label>
                <input type="text" name="transaction_id" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block font-semibold">Payment Status:</label>
                <select name="status" class="w-full p-2 border rounded" required>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
        </div>

        <div class="mt-6 text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Payment</button>
        </div>
    </form>
</div>
@endsection
