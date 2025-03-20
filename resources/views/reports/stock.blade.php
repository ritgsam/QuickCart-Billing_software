@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>📦 Low Stock Report</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Current Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($low_stock_products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td class="text-danger fw-bold">{{ $product->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
