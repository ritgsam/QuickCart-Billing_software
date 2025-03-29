@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1 class="fw-bold text-dark mb-4"> Reports Dashboard</h1>
        <p class="text-secondary fs-5">Analyze your sales, purchases, stock, and financial reports.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-3 h-100" style="background-color: #f5ebe0;"">
                <div class="card-body text-center p-5">
                    <h2 class="fw-bold text-danger">📈 Sales Reports</h2>
                    <p class="fs-5 text-muted">Track sales by customer, product, and time period.</p>
                    <a href="{{ route('reports.sales') }}" class="btn btn-danger btn-lg w-75 mt-3 rounded-pill">View Reports</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-3 h-100" style="background-color: #f5ebe0;"">
                <div class="card-body text-center p-5">
                    <h2 class="fw-bold text-danger">📉 Purchase Reports</h2>
                    <p class="fs-5 text-muted">Analyze purchases by supplier and pending payments.</p>
                    <a href="{{ route('reports.purchases') }}" class="btn btn-danger btn-lg w-75 mt-3 rounded-pill">View Reports</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-3 h-100" style="background-color: #f5ebe0;">
                <div class="card-body text-center p-5">
                    <h2 class="fw-bold text-danger bi bi-box-seam"> Stock Reports</h2>
                    <p class="fs-5 text-muted">Monitor low stock alerts and stock movements.</p>
                    <a href="{{ route('reports.stock') }}" class="btn btn-danger btn-lg w-75 mt-3 rounded-pill">View Reports</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-3 h-100" style="background-color: #f5ebe0;">
                <div class="card-body text-center p-5">
                    <h2 class="fw-bold text-danger bi bi-bank"> Financial Reports</h2>
                    <p class="fs-5 text-muted">Review profit & loss statements and cash flow.</p>
                    <a href="{{ route('reports.financial') }}" class="btn btn-danger btn-lg w-75 mt-3 rounded-pill">View Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
