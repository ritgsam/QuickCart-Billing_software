@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-dark bi bi-box-seam"> Low Stock Report</h1>
        <p class="text-secondary fs-5">Monitor products with critically low stock levels.</p>
    </div>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle text-center">
                    <thead class="table-danger">
                        <tr>
                            <th class="fs-5">Product Name</th>
                            <th class="fs-5">Current Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($low_stock_products as $product)
                        <tr>
                            <td class="fw-semibold">{{ $product->name }}</td>
                            <td class="fs-5 text-danger fw-bold">
                                <span class="badge bg-danger text-white p-2">{{ $product->stock }}</span>
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

