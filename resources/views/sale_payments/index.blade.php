@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Sale Invoice Payments</h4>
            <a href="{{ route('sale_payments.create') }}" class="btn btn-light">+ Add Payment</a>
        </div>

        <div class="card-body bg-light">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Payment Date</th>
                            <th>Amount Paid (₹)</th>
                            <th>Payment Mode</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->saleInvoice->invoice_number ?? 'N/A' }}</td>
                            <td>{{ $payment->payment_date }}</td>
                            <td>₹{{ number_format($payment->amount_paid, 2) }}</td>
                            <td>{{ ucfirst($payment->payment_mode) }}</td>
                            <td>
                                <span class="badge
                                    {{ $payment->status == 'Completed' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('sale_payments.edit', $payment->id) }}" class="btn text-white btn-sm"style="background-color: rgba(43, 42, 42, 0.694);">Edit</a>
                                <form action="{{ route('sale_payments.destroy', $payment->id) }}" method="POST" class="d-inline">
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
