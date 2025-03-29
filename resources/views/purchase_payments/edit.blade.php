@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-3xl font-bold mb-4 text-gray-800">Edit Purchase Payment</h2>

        <form action="{{ route('purchase_payments.update', $purchasePayment->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="purchase_invoice_id" class="font-semibold text-gray-700">Select Invoice:</label>
                <select name="purchase_invoice_id" class="w-full border-gray-300 rounded-lg p-2">
                    <option value="">Select Invoice</option>
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->id }}" {{ $purchasePayment->purchase_invoice_id == $invoice->id ? 'selected' : '' }}>
                            {{ $invoice->invoice_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Payment Date:</label>
                    <input type="date" name="payment_date" value="{{ $purchasePayment->payment_date }}" class="w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Amount Paid (₹):</label>
                    <input type="number" name="amount_paid" value="{{ $purchasePayment->amount_paid }}" class="w-full border-gray-300 rounded-lg p-2">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Discount (₹):</label>
                    <input type="number" name="discount" value="{{ $purchasePayment->discount }}" class="w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="font-semibold text-gray-700">GST (%):</label>
                    <input type="number" name="gst" value="{{ $purchasePayment->gst }}" class="w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Round Off (₹):</label>
                    <input type="number" name="round_off" value="{{ $purchasePayment->round_off }}" class="w-full border-gray-300 rounded-lg p-2">
                </div>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Balance Due (₹):</label>
                <input type="number" name="balance_due" value="{{ $purchasePayment->balance_due }}" class="w-full border-gray-300 rounded-lg p-2">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Payment Mode:</label>
                    <select name="payment_mode" class="w-full border-gray-300 rounded-lg p-2">
                        <option value="Cash" {{ $purchasePayment->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Card" {{ $purchasePayment->payment_mode == 'Card' ? 'selected' : '' }}>Card</option>
                        <option value="UPI" {{ $purchasePayment->payment_mode == 'UPI' ? 'selected' : '' }}>UPI</option>
                        <option value="Bank Transfer" {{ $purchasePayment->payment_mode == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Status:</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg p-2">
                        <option value="Completed" {{ $purchasePayment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pending" {{ $purchasePayment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-gray-700 text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                    Update Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
