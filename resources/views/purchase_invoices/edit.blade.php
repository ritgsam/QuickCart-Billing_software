@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Purchase Invoice</h1>

    <form action="{{ route('purchase_invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block">Supplier:</label>
            <select name="supplier_id" class="w-full p-2 border rounded" required>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $supplier->id == $invoice->supplier_id ? 'selected' : '' }}>
                        {{ $supplier->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block">Invoice Date:</label>
            <input type="date" name="invoice_date" value="{{ $invoice->invoice_date }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Due Date:</label>
            <input type="date" name="due_date" value="{{ $invoice->due_date }}" class="w-full p-2 border rounded">
        </div>

        <h2 class="text-2xl font-bold mt-6">Invoice Items</h2>

        <table class="w-full mt-4 border bg-white">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Product</th>
                    <th class="px-4 py-2 border">Quantity</th>
                    <th class="px-4 py-2 border">Unit Price</th>
                    <th class="px-4 py-2 border">Tax (%)</th>
                    <th class="px-4 py-2 border">Discount (%)</th>
                    <th class="px-4 py-2 border">Total</th>
                </tr>
            </thead>
            <tbody id="invoice-items">
@foreach ($invoice->items as $index => $item)
    <tr class="product-row">
        <td class="px-4 py-2 border">
            <select name="products[{{ $index }}][product_id]" class="product-select w-full p-2 border rounded" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                        data-price="{{ $product->purchase_price }}"
                        data-gst="{{ $product->gst_rate }}"
                        data-discount="{{ $product->discount }}"
                        {{ $product->id == $item->product_id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td class="px-4 py-2 border">
            <input type="number" name="products[{{ $index }}][quantity]" class="quantity w-full p-2 border rounded" value="{{ $item->quantity }}" required>
        </td>
        <td class="px-4 py-2 border">
            <input type="number" name="products[{{ $index }}][unit_price]" class="unit-price w-full p-2 border rounded" value="{{ $item->unit_price }}" readonly>
        </td>
        <td class="px-4 py-2 border">
            <select name="products[{{ $index }}][gst_rate]" class="gst-rate w-full p-2 border rounded" required>
                <option value="5" {{ $item->gst_rate == 5 ? 'selected' : '' }}>5%</option>
                <option value="12" {{ $item->gst_rate == 12 ? 'selected' : '' }}>12%</option>
                <option value="18" {{ $item->gst_rate == 18 ? 'selected' : '' }}>18%</option>
                <option value="28" {{ $item->gst_rate == 28 ? 'selected' : '' }}>28%</option>
            </select>
        </td>
        <td class="px-4 py-2 border">
            <input type="number" name="products[{{ $index }}][discount]" class="discount w-full p-2 border rounded" value="{{ $item->discount }}">
        </td>
        <td class="px-4 py-2 border">
            <input type="number" name="products[{{ $index }}][total_price]" class="total-price w-full p-2 border rounded" value="{{ $item->total_price }}" readonly>
        </td>
        <td class="px-4 py-2 border text-center">
            <button type="button" class="remove-product text-red-500 font-bold">✖</button>
        </td>
    </tr>
    @endforeach
</tbody>
        </table>

        <div class="mt-4">
            <label class="block">Invoice Notes:</label>
            <textarea name="invoice_notes" class="w-full p-2 border rounded">{{ $invoice->invoice_notes }}</textarea>
        </div>

        <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded" style="background-color: rgba(43, 42, 42, 0.694);">Update Invoice</button>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-row').forEach(row => {
        let selectElement = row.querySelector('.product-select');
        fetchProductDetails(selectElement);
    });

    document.querySelectorAll('.quantity, .gst-rate, .discount').forEach(input => {
        input.addEventListener('input', updateTotal);
    });

    updateTotal();
});
</script>
@endsection
