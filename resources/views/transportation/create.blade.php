
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-dark text-white fw-bold">
                    Add Transportation
                </div>

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('transportations.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Invoice:</label>
                                <select name="sale_invoice_id" class="form-select" required>
                                    <option value="">-- Select Invoice --</option>
                                    @foreach ($saleInvoices as $invoice)
                                        <option value="{{ $invoice->id }}">
                                            {{ $invoice->invoice_number }} - {{ $invoice->customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Transporter Name:</label>
                                <input type="text" name="transporter_name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Vehicle Number:</label>
                                <input type="text" name="vehicle_number" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Dispatch Date:</label>
                                <input type="date" name="dispatch_date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Expected Delivery Date:</label>
                                <input type="date" name="expected_delivery_date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status:</label>
                                <select name="status" class="form-select">
                                    <option value="Pending">Pending</option>
                                    <option value="In Transit">In Transit</option>
                                    <option value="Delivered">Delivered</option>
                                </select>
                            </div>

                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn text-white px-4" style="background-color: rgba(43, 42, 42, 0.694);">
                                Save Transportation
                            </button>
                            <a href="{{ route('transportations.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
