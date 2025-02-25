@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Product List</h1>

    <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Add Product</a>
<br>
<form method="GET" action="{{ route('products.index') }}">
    <select name="category_id" class="w-full p-2 border rounded" onchange="this.form.submit()">
        <option value="">All Categories</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</form>

    <table class="w-full mt-4 border bg-white">
    <thead>
        <tr class="bg-gray-200">
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">SKU</th>
            <th class="px-4 py-2 border">Category</th>
            <th class="px-4 py-2 border">Price</th>
            <th class="px-4 py-2 border">Stock</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
        <tr class="border">
            <td class="px-4 py-2 border">{{ $product->name }}</td>
            <td class="px-4 py-2 border">{{ $product->sku }}</td>
            <td class="px-4 py-2 border">{{ $product->category->name ?? 'N/A' }}</td>
            <td class="px-4 py-2 border">{{ $product->selling_price }}</td>
            <td class="px-4 py-2 border">{{ $product->stock }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-4 py-2 border text-center text-red-500">No Products Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>
@endsection

