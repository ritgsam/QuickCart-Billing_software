@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>📈 Sales Report</h2>

    <form method="GET" class="mb-3">
        <label>Start Date:</label>
        <input type="date" name="start_date" value="{{ $start_date }}" class="form-control">

        <label>End Date:</label>
        <input type="date" name="end_date" value="{{ $end_date }}" class="form-control">

        <button type="submit" class="btn btn-primary mt-2">Filter</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Invoice Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->invoice_number }}</td>
                <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                <td>₹{{ number_format($sale->total_amount, 2) }}</td>
                <td>{{ $sale->invoice_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

