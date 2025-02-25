@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-3 gap-6">
        <div class="bg-blue-100 p-4 rounded-lg">
            <h2 class="text-lg font-bold">Total Sales (This Month)</h2>
            <p class="text-xl font-semibold">₹{{ number_format($total_sales_month, 2) }}</p>
        </div>
        <div class="bg-green-100 p-4 rounded-lg">
            <h2 class="text-lg font-bold">Total Purchases (This Month)</h2>
            <p class="text-xl font-semibold">₹{{ number_format($total_purchases_month, 2) }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded-lg">
            <h2 class="text-lg font-bold">Pending Customer Payments</h2>
            <p class="text-xl font-semibold">₹{{ number_format($pending_customer_payments, 2) }}</p>
        </div>
        <div class="bg-red-100 p-4 rounded-lg">
            <h2 class="text-lg font-bold">Pending Supplier Payments</h2>
            <p class="text-xl font-semibold">₹{{ number_format($pending_supplier_payments, 2) }}</p>
        </div>
    </div>

    <div class="mt-6">
    <h2 class="text-2xl font-bold">Low Stock Alerts</h2>
    @if ($low_stock_products->isEmpty())
        <p class="text-gray-600">All products have sufficient stock.</p>
    @else
        <table class="w-full mt-4 border bg-white">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Product</th>
                    <th class="px-4 py-2 border">Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($low_stock_products as $product)
                <tr class="border">
                    <td class="px-4 py-2 border">{{ $product->name }}</td>
                    <td class="px-4 py-2 border text-red-600 font-bold">{{ $product->stock_quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>


    <div class="mt-6">
        <h2 class="text-2xl font-bold">Quick Links</h2>
        <div class="flex gap-4 mt-4">
            <a href="{{ route('sales.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Add Invoice</a>
            <a href="{{ route('products.create') }}" class="px-4 py-2 bg-green-500 text-white rounded">Add Product</a>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">View Reports</a>
        </div>
    </div>
</div>
@endsection
