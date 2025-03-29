@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header text-white" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Edit Credit Note</h4>
        </div>

        <div class="card-body" style="background-color: #f5ebe0;">
            <form action="{{ route('credit_notes.update', $creditNote->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="fw-bold">Sale Invoice:</label>
                    <select name="sale_invoice_id" class="form-select" required>
                        @foreach ($saleInvoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ $creditNote->sale_invoice_id == $invoice->id ? 'selected' : '' }}>
                                {{ $invoice->invoice_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Customer:</label>
                    <select name="customer_id" class="form-select" required>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $creditNote->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Actual Amount:</label>
                        <input type="number" name="actual_amount" class="form-control" value="{{ $creditNote->actual_amount }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Tax Amount:</label>
                        <input type="number" name="tax_amount" class="form-control" value="{{ $creditNote->tax_amount }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Round Off:</label>
                        <input type="number" name="round_off" class="form-control" value="{{ $creditNote->round_off }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Total Amount:</label>
                        <input type="number" name="total_amount" class="form-control fw-bold text-success" value="{{ $creditNote->total_amount }}" required>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-dark">Update</button>
                    <a href="{{ route('credit_notes.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
