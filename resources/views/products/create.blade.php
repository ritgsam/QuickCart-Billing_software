{{--
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Add New Product</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" class="bg-white p-6 shadow rounded">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">Product Name:</label>
                <input type="text" name="name" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Category:</label>
                <select name="category_id" class="w-full p-2 border rounded" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold">Purchase Price:</label>
                <input type="number" step="0.01" name="purchase_price" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Selling Price:</label>
                <input type="number" step="0.01" name="selling_price" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Stock Quantity:</label>
                <input type="number" name="stock" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">GST Rate (%):</label>
                <input type="number" step="0.01" name="gst_rate" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block font-semibold">Discount (%):</label>
                <input type="number" step="0.01" name="discount" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block font-semibold">Status:</label>
                <select name="visibility" class="w-full p-2 border rounded" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-6 text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Product</button>
        </div>
    </form>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Add New Product</h4>
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

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="category" class="form-label">Category:</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="purchase_price" class="form-label">Purchase Price:</label>
                        <input type="number" step="0.01" name="purchase_price" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label for="selling_price" class="form-label">Selling Price:</label>
                        <input type="number" step="0.01" name="selling_price" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label for="stock" class="form-label">Stock Quantity:</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="gst" class="form-label">GST Rate (%):</label>
                        <input type="number" step="0.01" name="gst_rate" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label for="discount" class="form-label">Discount (%):</label>
                        <input type="number" step="0.01" name="discount" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label for="visibility" class="form-label">Status:</label>
                        <select name="visibility" class="form-select" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Save Product</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
