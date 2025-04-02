
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-white" style="background-color: rgb(61, 60, 60);">
            <h4>Add New Product</h4>
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
                <div class="mb-3">
                        <label for="hsn_code" class="form-label">HSN Code</label>
                        <input type="text" class="form-control" id="hsn_code" name="hsn_code" value="{{ old('hsn_code', $product->hsn_code ?? '') }}" style="width: 20%">
                    </div>
                <div class="mt-4">
                    <button type="submit" class="btn text-white" style="background-color: rgba(43, 42, 42, 0.694);">Save Product</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
