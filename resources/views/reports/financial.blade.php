
@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background-color:#f5ebe0">
    <div class="text-center mb-4" >
        <h1 class="fw-bold text-dark bi bi-bank"> Financial Report</h1>
        <p class="text-secondary fs-5">Overview of sales, purchases, and net profit.</p>
    </div>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <table class="table table-hover table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="fs-5">Metric</th>
                        <th class="fs-5">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-semibold">Total Sales</td>
                        <td class="fs-5 text-primary">₹{{ number_format($total_sales, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Total Purchases</td>
                        <td class="fs-5 text-danger">₹{{ number_format($total_purchases, 2) }}</td>
                    </tr>
                    <tr class="table-light">
                        <td class="fw-semibold">Net Profit</td>
                        <td class="fs-5 fw-bold {{ $profit >= 0 ? 'text-success' : 'text-danger' }}">
                            ₹{{ number_format($profit, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
