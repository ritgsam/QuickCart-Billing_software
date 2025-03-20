@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1 class="fw-bold text-primary mb-4"> Reports Dashboard</h1>
        <p class="text-muted">Reports for sales, purchases, stock, and financials.</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h4 class="card-title text-primary fw-bold">📈 Sales Reports</h4>
                    <p class="card-text text-muted">Track sales by customer, product, and time period.</p>
                    <a href="{{ route('reports.sales') }}" class="btn btn-primary w-100 fw-semibold">View Sales Reports</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h4 class="card-title text-warning fw-bold">📉 Purchase Reports</h4>
                    <p class="card-text text-muted">Analyze purchases by supplier and pending payments.</p>
                    <a href="{{ route('reports.purchases') }}" class="btn btn-warning w-100 fw-semibold">View Purchase Reports</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h4 class="card-title text-success fw-bold">📦 Stock Reports</h4>
                    <p class="card-text text-muted">Monitor low stock alerts and stock movements.</p>
                    <a href="{{ route('reports.stock') }}" class="btn btn-success w-100 fw-semibold">View Stock Reports</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h4 class="card-title text-danger fw-bold">💰 Financial Reports</h4>
                    <p class="card-text text-muted">Review profit & loss statements and cash flow.</p>
                    <a href="{{ route('reports.financial') }}" class="btn btn-danger w-100 fw-semibold">View Financial Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
