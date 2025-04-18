
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

                    <h5 class="mt-4 font-bold">Country-wise Pricing</h5>
                    <div id="country-price-section">
                        <div class="row mb-2 country-price-row">
                            <div class="col-md-5">
                                <label>Country</label>
                                <select name="country_prices[0][country_id]" class="form-control" required>
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label>Price</label>
                                <input type="number" name="country_prices[0][price]" class="form-control" step="0.01" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class=" btn w-80 h-8 btn-sm btn-secondary mt-2" id="add-country-price">+ Add More</button>
                    {{-- <div class="col-md-4">
                         <label for="visibility" class="form-label">Status:</label>
                        <select name="visibility" class="form-select" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div> --}}
                <div class="mb-3">
                        <label for="hsn_code" class="form-label">HSN Code</label>
                        <input type="text" class="form-control" id="hsn_code" name="hsn_code" value="{{ old('hsn_code', $product->hsn_code ?? '') }}" style="width: 20%">
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
                    <button type="submit" class="btn text-white" style="background-color: rgba(43, 42, 42, 0.694);">Save Product</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
let index = 1;
document.getElementById('add-country-price').addEventListener('click', function () {
    const section = document.getElementById('country-price-section');
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mb-2', 'country-price-row');

    newRow.innerHTML = `
        <div class="col-md-5">
            <label>Country</label>
            <select name="country_prices[${index}][country_id]" class="form-control" required>
                <option value="">-- Select Country --</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <label>Price</label>
            <input type="number" name="country_prices[${index}][price]" class="form-control" step="0.01" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-row">Remove</button>
        </div>
    `;
    section.appendChild(newRow);
    index++;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('.country-price-row').remove();
    }
});






    let priceRowIndex = 1;

    document.getElementById('add-country-price').addEventListener('click', function () {
        const wrapper = document.getElementById('country-price-wrapper');
        const newRow = document.createElement('div');
        newRow.classList.add('country-price-row', 'flex', 'gap-4', 'mb-3');

        newRow.innerHTML = `
            <select name="prices[${priceRowIndex}][country_id]" class="form-select w-1/2" required>
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <input type="number" name="prices[${priceRowIndex}][price]" step="0.01" placeholder="Price"
                   class="form-input w-1/2" required>
            <button type="button" class="remove-row text-red-500">✕</button>
        `;

        wrapper.appendChild(newRow);
        priceRowIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.country-price-row').remove();
        }
    });
</script>
@endsection
