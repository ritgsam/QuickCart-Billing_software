@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg" >
        <div class="card-header text-white" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Add Customer</h4>
        </div>
        <div class="card-body"  style="background-color:  #f5ebe0;">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postal_code" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">GST Number</label>
                        <input type="text" name="gst_number" class="form-control">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('customers.index') }}"  class="btn btn-secondary me-2 " >Cancel</a>
                    <button type="submit" class="btn text-white " style="background-color: rgba(43, 42, 42, 0.694);">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
