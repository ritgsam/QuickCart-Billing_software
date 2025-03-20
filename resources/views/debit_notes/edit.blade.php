@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Debit Note</h1>

    <form action="{{ route('debit_notes.update', $debitNote->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Supplier:</label>
            <select name="supplier_id" class="form-control" required>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $debitNote->supplier_id == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Purchase Invoice:</label>
            <select name="purchase_invoice_id" class="form-control" required>
                @foreach ($purchaseInvoices as $invoice)
                    <option value="{{ $invoice->id }}" {{ $debitNote->purchase_invoice_id == $invoice->id ? 'selected' : '' }}>
                        {{ $invoice->invoice_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tax Amount (₹):</label>
            <input type="number" step="0.01" name="tax_amount" class="form-control" value="{{ $debitNote->tax_amount }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Round Off (₹):</label>
            <input type="number" step="0.01" name="round_off" class="form-control" value="{{ $debitNote->round_off }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Actual Amount (₹):</label>
            <input type="number" step="0.01" name="actual_amount" class="form-control" value="{{ $debitNote->actual_amount }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Total Amount (₹):</label>
            <input type="number" step="0.01" name="total_amount" class="form-control" value="{{ $debitNote->total_amount }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Debit Note</button>
        <a href="{{ route('debit_notes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
