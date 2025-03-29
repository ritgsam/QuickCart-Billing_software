@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header text-white" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Credit Note Details</h4>
        </div>
        <div class="card-body" style="background-color: #f5ebe0;">
            <table class="table table-striped table-hover">
                <tbody>
                    <tr>
                        <th class="w-25">Invoice Number:</th>
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
                        <td class="fw-bold text-success">₹{{ number_format($creditNote->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="text-end">
                <a href="{{ route('credit_notes.index') }}" class="btn btn-dark">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
