@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Purchase Invoice Payments</h4>
            <a href="{{ route('purchase_payments.create') }}" class="btn btn-light fw-bold">+ Add Payment</a>
        </div>

        <div class="card-body bg-light">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice #</th>
                            <th>Supplier</th>
                            <th>Payment Date</th>
                            <th>GST (%)</th>
                            <th>Discount (%)</th>
                            <th>Amount Paid (₹)</th>
                            <th>Balance Due (₹)</th>
                            <th>Payment Mode</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchasePayments as $payment)
                            <tr>
                                <td>{{ $payment->purchaseInvoice->invoice_number ?? 'N/A' }}</td>
                                <td>{{ $payment->purchaseInvoice->supplier->company_name ?? 'N/A' }}</td>
                                <td>{{ $payment->payment_date }}</td>
                                <td>{{ $payment->gst }}%</td>
                                <td>{{ $payment->discount }}%</td>
                                <td>₹{{ number_format($payment->amount_paid, 2) }}</td>
                                <td>₹{{ number_format($payment->balance_due, 2) }}</td>
                                <td>{{ ucfirst($payment->payment_mode) }}</td>
                                <td>
                                    <span class="badge {{ $payment->status == 'Completed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('purchase_payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">
                                         Edit
                                    </a>
                                    <form action="{{ route('purchase_payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                             Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
