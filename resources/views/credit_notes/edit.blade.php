@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Credit Note</h1>

    <form action="{{ route('credit_notes.update', $creditNote->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Sale Invoice:</label>
            <select name="sale_invoice_id" class="form-control" required>
                @foreach ($saleInvoices as $invoice)
                    <option value="{{ $invoice->id }}" {{ $creditNote->sale_invoice_id == $invoice->id ? 'selected' : '' }}>
                        {{ $invoice->invoice_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Customer:</label>
            <select name="customer_id" class="form-control" required>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $creditNote->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Actual Amount:</label>
            <input type="number" name="actual_amount" class="form-control" value="{{ $creditNote->actual_amount }}" required>
        </div>

        <div class="mb-3">
            <label>Tax Amount:</label>
            <input type="number" name="tax_amount" class="form-control" value="{{ $creditNote->tax_amount }}" required>
        </div>

        <div class="mb-3">
            <label>Round Off:</label>
            <input type="number" name="round_off" class="form-control" value="{{ $creditNote->round_off }}">
        </div>

        <div class="mb-3">
            <label>Total Amount:</label>
            <input type="number" name="total_amount" class="form-control" value="{{ $creditNote->total_amount }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('credit_notes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
