{{-- @extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-5xl bg-white shadow-md rounded-lg p-8 border border-gray-200">
        <h1 class="text-3xl font-semibold text-gray-800 text-center mb-6"> Add Customer</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Name *</label>
                        <input type="text" name="name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Email *</label>
                        <input type="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Phone *</label>
                        <input type="text" name="phone" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">City</label>
                        <input type="text" name="city" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">State</label>
                        <input type="text" name="state" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Address</label>
                        <textarea name="address" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Postal Code</label>
                        <input type="text" name="postal_code" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">GST Number</label>
                        <input type="text" name="gst_number" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105">
                 Save Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

 --}}

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Customer</h4>
        </div>
        <div class="card-body">
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
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
