
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center fw-bold">Edit Product</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-body" style="background-color: #f5ebe0;">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                        @error('name')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Purchase Price (₹)</label>
                        <input type="number" step="0.01" name="purchase_price"
                               value="{{ old('purchase_price', $product->purchase_price) }}"
                               class="form-control" required>
                        @error('purchase_price')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Selling Price (₹)</label>
                        <input type="number" step="0.01" name="selling_price"
                               value="{{ old('selling_price', $product->selling_price) }}"
                               class="form-control" required>
                        @error('selling_price')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">GST Rate (%)</label>
                        <input type="number" step="0.01" name="gst_rate"
                               value="{{ old('gst_rate', $product->gst_rate) }}"
                               class="form-control" required>
                        @error('gst_rate')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Discount (%)</label>
                        <input type="number" step="0.01" name="discount"
                               value="{{ old('discount', $product->discount) }}"
                               class="form-control">
                        @error('discount')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Stock Quantity</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                               class="form-control" required>
                        @error('stock')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="visibility" class="form-select" required>
                            <option value="1" {{ old('visibility', $product->visibility) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('visibility', $product->visibility) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('visibility')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="hsn_code" class="form-label">HSN Code</label>
                        <input type="text" class="form-control" id="hsn_code" name="hsn_code" value="{{ old('hsn_code', $product->hsn_code ?? '') }}" style="width: 20%">
                    </div>
                    <div class="col-md-12 text-center mt-4">
                        <button type="submit" class="btn text-white px-4" style="background-color: rgba(43, 42, 42, 0.694);">Update Product</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
