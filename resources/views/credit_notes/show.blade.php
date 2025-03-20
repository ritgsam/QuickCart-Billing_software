@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Credit Note Details</h1>

    <table class="table table-bordered">
        <tr>
            <th>Invoice Number:</th>
            <td>{{ $creditNote->saleInvoice->invoice_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Customer:</th>
            <td>{{ $creditNote->customer->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Actual Amount:</th>
            <td>₹{{ number_format($creditNote->actual_amount, 2) }}</td>
        </tr>
        <tr>
            <th>Tax Amount:</th>
            <td>₹{{ number_format($creditNote->tax_amount, 2) }}</td>
        </tr>
        <tr>
            <th>Total Amount:</th>
            <td>₹{{ number_format($creditNote->total_amount, 2) }}</td>
        </tr>
    </table>

    <a href="{{ route('credit_notes.index') }}" class="btn btn-primary">Back</a>
</div>
@endsection
