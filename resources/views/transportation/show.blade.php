@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2><b>Transportation Details</b></h2>
<br>

    <table class="table table-bordered">
        <tr><th>Invoice</th><td>{{ $transportation->saleInvoice->invoice_number }}</td></tr>
        <tr><th>Customer</th><td>{{ $transportation->saleInvoice->customer->name ?? 'N/A' }}</td></tr>
        <tr><th>Transporter</th><td>{{ $transportation->transporter_name }}</td></tr>
        <tr><th>Vehicle Number</th><td>{{ $transportation->vehicle_number }}</td></tr>
        <tr><th>Dispatch Date</th><td>{{ $transportation->dispatch_date }}</td></tr>
        <tr><th>Expected Delivery</th><td>{{ $transportation->expected_delivery_date }}</td></tr>
        <tr><th>Status</th><td>{{ $transportation->status }}</td></tr>
    </table>

    <a href="{{ route('transportations.index') }}" class="btn btn-dark">← Back to List</a>
</div>
@endsection
