@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Sales Invoice</h1>

<form action="{{ url('sale-invoices/' . $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block font-semibold">Customer:</label>
            <select name="customer_id" class="w-full p-2 border rounded" required>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $customer->id == $invoice->customer_id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Invoice Date:</label>
            <input type="date" name="invoice_date" class="w-full p-2 border rounded" value="{{ $invoice->invoice_date }}" required>
        </div>

        <h2 class="text-xl font-bold mt-6 mb-4">Invoice Items</h2>
        <table id="invoice-items" class="w-full border bg-white">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Product</th>
                    <th class="px-4 py-2 border">Quantity</th>
                    <th class="px-4 py-2 border">Unit Price</th>
                    <th class="px-4 py-2 border">Tax (%)</th>
                    <th class="px-4 py-2 border">Total Price</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $index => $item)
                <tr class="product-row">
                    <td class="px-4 py-2 border">
                        <select name="products[{{ $index }}][product_id]" class="product-select w-full p-2 border rounded" required>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}"
                                    {{ $product->id == $item->product_id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-4 py-2 border"><input type="number" name="products[{{ $index }}][quantity]" class="quantity w-full p-2 border rounded" value="{{ $item->quantity }}" required></td>
                    <td class="px-4 py-2 border"><input type="number" name="products[{{ $index }}][unit_price]" class="unit-price w-full p-2 border rounded" value="{{ $item->unit_price }}" readonly></td>
<td class="px-4 py-2 border">
    <select name="products[0][gst_rate]" class="gst-rate w-full p-2 border rounded" onchange="updateTotal()">
        <option value="5">5%</option>
        <option value="12">12%</option>
        <option value="18" selected>18%</option>
        <option value="28">28%</option>
    </select>
</td>

<td class="px-4 py-2 border"><input type="number" name="products[{{ $index }}][discount]" class="discount w-full p-2 border rounded" value="{{ $item->discount }}"></td>
                    <td class="px-4 py-2 border"><input type="number" name="products[{{ $index }}][total_price]" class="total-price w-full p-2 border rounded" value="{{ $item->total_price }}" readonly></td>
                    <td class="px-4 py-2 border text-center"><button type="button" class="remove-product text-red-500 font-bold">✖</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" style="background-color: rgba(43, 42, 42, 0.694);>Update Invoice</button>
            <a href="{{ route('sale_invoices.index') }}" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</a>
        </div>
    </form>
</div>
<script>
function fetchProductDetails(selectElement) {
    let selectedOption = selectElement.options[selectElement.selectedIndex];

    let row = selectElement.closest('.product-row');
    row.querySelector('.unit-price').value = selectedOption.getAttribute('data-price');
    row.querySelector('.gst-rate').value = selectedOption.getAttribute('data-gst');
    row.querySelector('.discount').value = selectedOption.getAttribute('data-discount');

    updateTotal();
}

function updateTotal() {
    let totalAmount = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        let qty = parseFloat(row.querySelector('.quantity').value) || 0;
        let price = parseFloat(row.querySelector('.unit-price').value) || 0;
        let gst = parseFloat(row.querySelector('.gst-rate').value) || 0;
        let discount = parseFloat(row.querySelector('.discount').value) || 0;

        let subtotal = qty * price;
        let gstAmount = (subtotal * gst) / 100;
        let discountAmount = (subtotal * discount) / 100;
        let totalPrice = subtotal + gstAmount - discountAmount;

        row.querySelector('.total-price').value = totalPrice.toFixed(2);
        totalAmount += totalPrice;
    });

    document.getElementById('total-amount').value = totalAmount.toFixed(2);
}

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
