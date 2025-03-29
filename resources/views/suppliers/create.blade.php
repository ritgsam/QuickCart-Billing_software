@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header  text-white text-center" style="background-color: rgb(61, 60, 60);">
                    <h4 class="mb-0">Add Supplier</h4>
                </div>

                <div class="card-body p-4" style="background-color: #f5ebe0;">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('suppliers.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Company Name *</label>
                                    <input type="text" name="company_name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email *</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone *</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">GST Number</label>
                                    <input type="text" name="gst_number" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Payment Terms</label>
                                    <input type="text" name="payment_terms" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <textarea name="address" class="form-control"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn text-white px-4" style="background-color: rgba(43, 42, 42, 0.694);">Save Supplier</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
