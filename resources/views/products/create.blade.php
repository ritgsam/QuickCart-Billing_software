@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Add Product</h1>

    <form action="{{ route('products.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Product Name" class="w-full p-2 border rounded" required>
    <input type="number" name="purchase_price" placeholder="Purchase Price" class="w-full p-2 border rounded" required>
    <input type="number" name="selling_price" placeholder="Selling Price" class="w-full p-2 border rounded" required>
    <select name="visibility" class="w-full p-2 border rounded" required>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
    <input type="number" name="stock" placeholder="Stock Quantity" class="w-full p-2 border rounded" required>
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
</form>
</div>
@endsection
