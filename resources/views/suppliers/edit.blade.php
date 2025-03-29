@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header text-white" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Edit Supplier</h4>
        </div>
        <div class="card-body" style="background-color: #f5ebe0;">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Name *</label>
                        <input type="text" name="company_name" class="form-control" value="{{ $supplier->company_name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ $supplier->email }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-control" value="{{ $supplier->phone }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">GST Number</label>
                        <input type="text" name="gst_number" class="form-control" value="{{ $supplier->gst_number }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address *</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ $supplier->address }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Terms</label>
                        <input type="text" name="payment_terms" class="form-control" value="{{ $supplier->payment_terms }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn text-white" style="background-color: rgba(43, 42, 42, 0.694);">Update Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
