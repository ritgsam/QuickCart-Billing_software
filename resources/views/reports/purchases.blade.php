@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>📉 Purchase Report</h2>

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
                <th>Supplier</th>
                <th>Total Amount</th>
                <th>Invoice Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
            <tr>
                <td>{{ $purchase->invoice_number }}</td>
                <td>{{ $purchase->supplier->company_name ?? 'N/A' }}</td>
                <td>₹{{ number_format($purchase->total_amount, 2) }}</td>
                <td>{{ $purchase->invoice_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
