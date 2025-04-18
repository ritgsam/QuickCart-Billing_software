
@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header text-white" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Create Credit Note</h4>
        </div>
        <div class="card-body" style="background-color: #f5ebe0;">
            <form action="{{ route('credit_notes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="sale_invoice_id" class="form-label">Select Invoice:</label>
                    <select name="sale_invoice_id" id="sale_invoice_id" class="form-select" required>
                        <option value="">-- Select Invoice --</option>
                        @foreach($saleInvoices as $invoice)
                            <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="credit_date" class="form-label">Credit Date:</label>
                        <input type="date" name="credit_date" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="total_amount" class="form-label">Total Amount:</label>
                        <input type="number" name="total_amount" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason:</label>
                    <textarea name="reason" class="form-control" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('credit_notes.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn text-white" style="background-color: rgba(43, 42, 42, 0.694);">Save Credit Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#sale_invoice_id').select2({
            placeholder: "-- Select Invoice --",
            allowClear: true
        });
    });
</script>

@endsection
