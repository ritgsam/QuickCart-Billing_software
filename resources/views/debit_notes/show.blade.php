@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Debit Note Details</h2>

    <table class="table">
        <tr>
            <th>Supplier:</th>
            <td>
                {{ $debitNote->supplier->company_name ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <th>Purchase Invoice:</th>
            <td>
                {{ $debitNote->purchaseInvoice->invoice_number ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <th>Total Amount:</th>
            <td>₹{{ number_format($debitNote->total_amount, 2) }}</td>
        </tr>
    </table>
</div>
@endsection
