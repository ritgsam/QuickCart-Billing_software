
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-dark">📈 Sales Report</h1>
        <p class="text-secondary fs-5">Track and analyze sales within a selected date range.</p>
    </div>

    <div class="card shadow-lg border-0 rounded-3 mb-4">
        <div class="card-body" style="background-color: rgb(238, 231, 231)">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Start Date:</label>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">End Date:</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold"> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4" style="background-color: rgb(238, 231, 231)">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th class="fs-5">Invoice #</th>
                            <th class="fs-5">Customer</th>
                            <th class="fs-5">Total Amount (₹)</th>
                            <th class="fs-5">Invoice Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                        <tr>
                            <td class="fw-semibold">{{ $sale->invoice_number }}</td>
                            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                            <td class="fs-5 text-success">₹{{ number_format($sale->total_amount, 2) }}</td>
                            <td>{{ $sale->invoice_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
