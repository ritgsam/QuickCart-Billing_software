@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 shadow-md rounded-lg" style="background-color:#f5ebe0">
    <h1 class="text-3xl font-bold mb-6">Create Sales Invoice</h1>

    <form action="{{ route('sale_invoices.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">Customer:</label>
                <select name="customer_id" class="w-full p-2 border rounded" required>
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold">Invoice Date:</label>
                <input type="date" name="invoice_date" class="w-full p-2 border rounded" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block font-semibold">Payment Status:</label>
                <select name="payment_status" class="w-full p-2 border rounded" required>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                    <option value="Partial">Partial</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold">Due Date:</label>
                <input type="date" name="due_date" class="w-full p-2 border rounded">
            </div>
        </div>

        <h2 class="text-xl font-bold mt-6 mb-4">Invoice Items</h2>

        <table id="invoice-items" class="w-full border bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Product</th>
                    <th class="px-4 py-2 border">Quantity</th>
                    <th class="px-4 py-2 border">Unit Price</th>
                    <th class="px-4 py-2 border">GST (%)</th>
                    <th class="px-4 py-2 border">Discount (%)</th>
                    <th class="px-4 py-2 border">Total Price</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="product-row">
                    <td class="px-4 py-2 border">
                        <select name="products[0][product_id]" class="product-select w-full p-2 border rounded" required onchange="fetchProductDetails(this)">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-gst="{{ $product->gst_rate }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-4 py-2 border"><input type="number" name="products[0][quantity]" class="quantity w-full p-2 border rounded" value="1" required oninput="updateTotal()"></td>
                    <td class="px-4 py-2 border"><input type="number" name="products[0][unit_price]" class="unit-price w-full p-2 border rounded" value="0" readonly></td>
                    <td class="px-4 py-2 border">
                        <select name="products[0][gst_rate]" class="gst-rate w-full p-2 border rounded" required onchange="updateTotal()">
                            <option value="5">5%</option>
                            <option value="12">12%</option>
                            <option value="18">18%</option>
                            <option value="28">28%</option>
                        </select>
                    </td>
                    <td class="px-4 py-2 border"><input type="number" name="products[0][discount]" class="discount w-full p-2 border rounded" value="0" oninput="updateTotal()"></td>
                    <td class="px-4 py-2 border"><input type="number" name="products[0][total_price]" class="total-price w-full p-2 border rounded" value="0" readonly></td>
                    <td class="px-4 py-2 border text-center">
                        <button type="button" class="remove-product text-red-500 font-bold" onclick="removeProduct(this)">✖</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="add-product" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded">Add Another Product</button>

        <div class="mt-6">
            <label class="block font-semibold">Invoice Notes:</label>
            <textarea name="invoice_notes" class="w-full p-2 border rounded" placeholder="Enter notes (optional)"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block font-semibold">SubTotal:</label>
                <input type="number" id="total-amount" class="w-full p-2 border rounded" readonly>
            </div>
            <div>
                <label class="block font-semibold">Global Discount (%):</label>
                <input type="number" name="global_discount" class="w-full p-2 border rounded" step="0.01" value="0">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block font-semibold">Round Off:</label>
                <input type="number" name="round_off" class="w-full p-2 border rounded" step="0.01" value="0">
            </div>
            <div>
                <label class="block font-semibold">Final Amount:</label>
                <input type="hidden" name="final_amount" id="final-amount-hidden" >
                <input type="number" id="final-amount" class="w-full p-2 border rounded" readonly>
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded"style="background-color: rgba(43, 42, 42, 0.694);">Save Invoice</button>
            <a href="{{ route('sale_invoices.index') }}" class="bg-red-500 text-white px-4 py-2 rounded"style="background-color: rgba(43, 42, 42, 0.694);">Cancel</a>
        </div>
    </form>
</div>
<script>

document.getElementById('add-product').addEventListener('click', function() {
    let index = document.querySelectorAll('.product-row').length;
    let newRow = document.querySelector('.product-row').cloneNode(true);
    newRow.innerHTML = newRow.innerHTML.replace(/\[0\]/g, `[${index}]`);
    document.getElementById('invoice-items').querySelector('tbody').appendChild(newRow);

    newRow.querySelector('.remove-product').addEventListener('click', function() {
        newRow.remove();
        updateTotal();
    });

    attachChangeEvents(newRow);
});

document.querySelectorAll('.remove-product').forEach(button => {
    button.addEventListener('click', function() {
        this.parentElement.parentElement.remove();
        updateTotal();
    });
});
function attachChangeEvents(row) {
    let productSelect = row.querySelector('.product-select');
    let quantityInput = row.querySelector('.quantity');
    let gstRateInput = row.querySelector('.gst-rate');
    let discountInput = row.querySelector('.discount');

    if (productSelect) {
        productSelect.addEventListener('change', function() {
            fetchProductDetails(this);
        });
    }

    if (quantityInput) {
        quantityInput.addEventListener('input', updateTotal);
    }

    if (gstRateInput) {
        gstRateInput.addEventListener('input', updateTotal);
    }

    if (discountInput) {
        discountInput.addEventListener('input', updateTotal);
    }
}

function updateTotal() {
    let totalAmount = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        let qty = row.querySelector('.quantity').value;
        let price = row.querySelector('.unit-price').value;
        let tax = row.querySelector('.tax').value;
        let subtotal = qty * price;
        let taxAmount = (subtotal * tax) / 100;
        let totalPrice = subtotal + taxAmount;
        row.querySelector('.total-price').value = totalPrice.toFixed(2);
        totalAmount += totalPrice;
    });

    document.getElementById('total-amount').value = totalAmount.toFixed(2);
    let roundOff = parseFloat(document.querySelector('input[name="round_off"]').value) || 0;
    document.getElementById('final-amount').value = (totalAmount + roundOff).toFixed(2);
}

attachChangeEvents(document.querySelector('.product-row'));

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

    document.querySelectorAll('.product-row').forEach((row, index) => {
        let quantity = parseFloat(row.querySelector('.quantity').value) || 0;
        let unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
        let gstRate = parseFloat(row.querySelector('.gst-rate').value) || 0;
        let discount = parseFloat(row.querySelector('.discount').value) || 0;

        let itemTotal = quantity * unitPrice;

        let discountAmount = (itemTotal * discount) / 100;
        itemTotal -= discountAmount;

        let gstAmount = (itemTotal * gstRate) / 100;
        itemTotal += gstAmount;

        row.querySelector('.total-price').value = itemTotal.toFixed(2);

        totalAmount += itemTotal;
    });

    document.getElementById('total-amount').value = totalAmount.toFixed(2);

    let globalDiscount = parseFloat(document.querySelector('input[name="global_discount"]').value) || 0;
    let globalDiscountAmount = (totalAmount * globalDiscount) / 100;
    let finalAmount = totalAmount - globalDiscountAmount;

    let roundedFinalAmount = Math.round(finalAmount);
    let roundOff = (roundedFinalAmount - finalAmount).toFixed(2);

    document.querySelector('input[name="round_off"]').value = roundOff;
    document.getElementById('final-amount').value = roundedFinalAmount.toFixed(2);
    document.getElementById('final-amount-hidden').value = roundedFinalAmount.toFixed(2);
}
document.addEventListener('input', function (event) {
    if (event.target.classList.contains('quantity') ||
        event.target.classList.contains('discount') ||
        event.target.classList.contains('gst-rate') ||
        event.target.name === "global_discount") {
        updateTotal();
    }
});

function fetchProductDetails(selectElement) {
    let selectedOption = selectElement.options[selectElement.selectedIndex];

    if (selectedOption.value !== "") {
        let row = selectElement.closest('.product-row');
        row.querySelector('.unit-price').value = selectedOption.getAttribute('data-price');
        row.querySelector('.gst-rate').value = selectedOption.getAttribute('data-gst');
        row.querySelector('.discount').value = selectedOption.getAttribute('data-discount');
        updateTotal();
    }
}
</script>


@endsection
