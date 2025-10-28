

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 shadow-md rounded-lg bg-gray-100">
    <h1 class="text-2xl font-bold mb-6">Create Sale Invoice</h1>

    <form method="POST" action="{{ route('sale_invoices.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Customer:</label>
                <select name="customer_id" class="w-full border rounded p-2" required>
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Invoice Date:</label>
                <input type="date" name="invoice_date" class="w-full border rounded p-2" required>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label>Payment Status:</label>
                <select name="payment_status" class="w-full border rounded p-2" required>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                    <option value="Partial">Partial</option>
                </select>
            </div>
            <div>
                <label>Due Date:</label>
                <input type="date" name="due_date" class="w-full border rounded p-2">
            </div>
        </div>

        <h2 class="text-xl font-semibold mt-6">Products</h2>

        <table class="w-full border mt-4" id="product-table">
            <thead class="bg-gray-200">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>SGST %</th>
                    <th>CGST %</th>
                    <th>IGST %</th>
                    <th>Discount %</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="product-body">
                <tr class="product-row">
                    <td>
                        <select name="products[0][product_id]" class="product-select border rounded p-1 w-full" onchange="fillUnitPrice(this)">
                            <option value="">Select</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="products[0][quantity]" class="qty border rounded p-1 w-full" value="1"></td>
                    <td><input type="number" name="products[0][unit_price]" class="unit-price border rounded p-1 w-full" readonly></td>
                    <td>
                        <select name="products[0][sgst]" class="sgst border rounded p-1 w-full">
                            @foreach ([0,9] as $tax)
                                <option value="{{ $tax }}">{{ $tax }}%</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="products[0][cgst]" class="cgst border rounded p-1 w-full">
                            @foreach ([0,9] as $tax)
                                <option value="{{ $tax }}">{{ $tax }}%</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="products[0][igst]" class="igst border rounded p-1 w-full">
                            @foreach ([0, 5, 12, 18, 28] as $tax)
                                <option value="{{ $tax }}">{{ $tax }}%</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="products[0][discount]" class="discount border rounded p-1 w-full" value="0"></td>
                    <td><input type="number" name="products[0][total_price]" class="total border rounded p-1 w-full" readonly></td>
                    <td><button type="button" class="remove-row text-red-500">✖</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="add-row" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">+ Add Product</button>
<h3 class="text-lg font-semibold mt-6">Transportation Details</h3>
<div class="grid grid-cols-2 gap-4 mt-2">
    <div>
        <label>Transporter Name:</label>
        <input type="text" name="transporter_name" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label>Vehicle Number:</label>
        <input type="text" name="vehicle_number" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label>Dispatch Date:</label>
        <input type="date" name="dispatch_date" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label>Expected Delivery Date:</label>
        <input type="date" name="expected_delivery_date" class="w-full border rounded p-2">
    </div>
    <div class="col-span-2">
        <label>Status:</label>
        <select name="status" class="w-full border rounded p-2">
            <option value="Pending">Pending</option>
            <option value="Dispatched">Dispatched</option>
            <option value="Delivered">Delivered</option>
        </select>
    </div>
</div>

        <div class="grid grid-cols-2 gap-4 mt-6">
            {{-- <div>
                <label>Global Discount (%):</label>
                <input type="number" name="global_discount" id="global-discount" class="w-full border rounded p-2" value="0">
            </div> --}}
            <div>
                <label>Invoice Notes:</label>
                <textarea name="invoice_notes" class="w-full border rounded p-2"></textarea>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-4">
            <div>
                <label>Subtotal:</label>
                <input type="number" id="subtotal" class="w-full border rounded p-2" readonly>
            </div>
            <div>
                <label>Global Discount (%):</label>
                <input type="number" name="global_discount" id="global-discount" class="w-full border rounded p-2" value="0">
            </div>
            <div>
                <label>Round Off:</label>
                <input type="number" name="round_off" id="round-off" class="w-full border rounded p-2" readonly>
            </div>
            <div>
                <label>Final Amount:</label>
                <input type="hidden" name="final_amount" id="final-amount-hidden">
                <input type="number" id="final-amount" class="w-full border rounded p-2" readonly>
            </div>
        </div>

        <div class="mt-6">

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit Invoice</button>
            <a href="{{ route('sale_invoices.index') }}" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.querySelector('select[name="customer_id"]').addEventListener('change', function () {
        const customerId = this.value;

        fetch(`/customer-country-prices/${customerId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const selects = document.querySelectorAll('.product-select');
                selects.forEach(select => {
                    select.innerHTML = `<option value="">Select Product</option>`;
                    data.products.forEach(product => {
                        select.innerHTML += `<option value="${product.id}" data-price="${product.price}">${product.name}</option>`;
                    });
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    });

    function fillUnitPrice(select) {
        const price = select.selectedOptions[0].dataset.price || 0;
        const row = select.closest('tr');
        row.querySelector('.unit-price').value = price;
    }

    const customers = @json($customers);
    const productPrices = @json($products->mapWithKeys(function($product) {
        return [$product->id => $product->prices->mapWithKeys(function($price) {
            return [$price->country_id => $price->price];
        })];
    }));

    let rowIndex = 1;

    document.getElementById('add-row').addEventListener('click', () => {
        const tbody = document.getElementById('product-body');
        const row = document.querySelector('.product-row').cloneNode(true);

        row.querySelectorAll('input, select').forEach(el => {
            const name = el.getAttribute('name');
            if (name) {
                el.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIndex}]`));
            }
            if (!el.classList.contains('unit-price') && !el.classList.contains('total')) {
                el.value = el.classList.contains('discount') ? '0' : '1';
            }
        });

        tbody.appendChild(row);
        rowIndex++;
    });

    document.addEventListener('change', e => {
        if (e.target.classList.contains('product-select')) {
            fillUnitPrice(e.target);
        }
        calculateTotals();
    });

    document.addEventListener('input', () => calculateTotals());

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('tr');
            if (document.querySelectorAll('.product-row').length > 1) {
                row.remove();
                calculateTotals();
            }
        }
    });

    function fillUnitPrice(select) {
        const price = select.selectedOptions[0].dataset.price || 0;
        const row = select.closest('tr');
        row.querySelector('.unit-price').value = price;
    }

function calculateTotals() {
    let subtotal = 0;

    document.querySelectorAll('.product-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const price = parseFloat(row.querySelector('.unit-price').value) || 0;
        const sgst = parseFloat(row.querySelector('.sgst').value) || 0;
        const cgst = parseFloat(row.querySelector('.cgst').value) || 0;
        const igst = parseFloat(row.querySelector('.igst').value) || 0;
        const discount = parseFloat(row.querySelector('.discount').value) || 0;

        const base = qty * price;
        const discountAmount = base * (discount / 100);
        const afterDiscount = base - discountAmount;

        const sgstAmount = afterDiscount * (sgst / 100);
        const cgstAmount = afterDiscount * (cgst / 100);
        const igstAmount = afterDiscount * (igst / 100);

        const total = afterDiscount + sgstAmount + cgstAmount + igstAmount;

        row.querySelector('.total').value = total.toFixed(2);
        subtotal += total;
    });

    const globalDiscount = parseFloat(document.getElementById('global-discount').value) || 0;
    const discounted = subtotal - (subtotal * globalDiscount / 100);
    const rounded = Math.round(discounted);
    const roundOff = parseFloat((rounded - discounted).toFixed(2));

    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('round-off').value = roundOff;
    document.getElementById('final-amount').value = rounded;
    document.getElementById('final-amount-hidden').value = rounded;
}
</script>
@endsection
