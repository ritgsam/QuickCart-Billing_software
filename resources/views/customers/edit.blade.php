
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-white text-center">
                    <h4>Edit Customer</h4>
                </div>
                <div class="card-body bg-light">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name:</label>
                                <input type="text" name="name" value="{{ $customer->name }}" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email:</label>
                                <input type="email" name="email" value="{{ $customer->email }}" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone:</label>
                                <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Address:</label>
                                <textarea name="address" class="form-control" rows="3" required>{{ $customer->address }}</textarea>
                            </div>


                            <div class="col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-success px-4">Update</button>
                                <a href="{{ route('customers.index') }}" class="btn btn-secondary px-4">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
