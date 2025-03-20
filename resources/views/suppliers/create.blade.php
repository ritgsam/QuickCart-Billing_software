{{-- @extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-5xl bg-white shadow-md rounded-lg p-8 border border-gray-200">
        <h1 class="text-3xl font-semibold text-gray-800 text-center mb-6"> Add Supplier</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Company Name *</label>
                        <input type="text" name="company_name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition" required>
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
                        <label class="block text-gray-700 font-medium mb-1">GST Number</label>
                        <input type="text" name="gst_number" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Payment Terms</label>
                        <input type="text" name="payment_terms" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Address</label>
                        <textarea name="address" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Status</label>
                        <select name="status" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105">
                     Save Supplier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
 --}}


@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Add Supplier</h4>
                </div>

                <div class="card-body p-4">
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
                            <!-- Left Column -->
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

                            <!-- Right Column -->
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
                            <button type="submit" class="btn btn-primary px-4">Save Supplier</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
