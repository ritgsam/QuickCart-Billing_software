
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header text-white" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Edit Sale Payment</h4>
        </div>
        <div class="card-body" style="background-color: #f5ebe0;">
            <form action="{{ route('sale-payments.update', $salePayment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="sale_invoice_id" class="form-label fw-bold">Select Invoice</label>
                    <select name="sale_invoice_id" id="sale_invoice_id" class="form-control" required>
                        <option value="">Select Invoice</option>
                        @foreach ($invoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ $salePayment->sale_invoice_id == $invoice->id ? 'selected' : '' }}>
                                {{ $invoice->invoice_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Payment Date:</label>
                    <input type="date" name="payment_date" value="{{ $salePayment->payment_date }}" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Amount Paid (₹):</label>
                        <input type="number" name="amount_paid" value="{{ $salePayment->amount_paid }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Round Off (₹):</label>
                        <input type="number" name="round_off" value="{{ $salePayment->round_off }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Balance Due (₹):</label>
                        <input type="number" name="balance_due" value="{{ $salePayment->balance_due }}" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Payment Mode:</label>
                    <select name="payment_mode" class="form-control">
                        <option value="Cash" {{ $salePayment->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Card" {{ $salePayment->payment_mode == 'Card' ? 'selected' : '' }}>Card</option>
                        <option value="UPI" {{ $salePayment->payment_mode == 'UPI' ? 'selected' : '' }}>UPI</option>
                        <option value="Bank Transfer" {{ $salePayment->payment_mode == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <select name="status" class="form-control">
                        <option value="Completed" {{ $salePayment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pending" {{ $salePayment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-dark">Update Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

