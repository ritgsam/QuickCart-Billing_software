@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white text-center" style="background-color: rgb(61, 60, 60);">
                    <h4 class="mb-0">Add New Customer</h4>
                </div>

                <div class="card-body p-4" style="background-color: #f5ebe0;">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Customer Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">GST Number</label>
                                <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Credit Limit (₹)</label>
                                <input type="number" step="0.01" name="credit_limit" class="form-control" value="{{ old('credit_limit') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Payment Terms</label>
                                <input type="text" name="payment_terms" class="form-control" value="{{ old('payment_terms') }}">
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Customer Rating</label>
                                <select name="rating" class="form-select">
                                    <option value="">Select Rating</option>
                                    <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>★☆☆☆☆</option>
                                    <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>★★☆☆☆</option>
                                    <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>★★★☆☆</option>
                                    <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>★★★★☆</option>
                                    <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>★★★★★</option>
                                </select>
                            </div> --}}

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn text-white px-4" style="background-color: rgba(43, 42, 42, 0.694);">Save Customer</button>
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
