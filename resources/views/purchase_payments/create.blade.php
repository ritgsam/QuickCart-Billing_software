
@extends('layouts.app')

@php
    $purchasePayment = $purchasePayment ?? new \App\Models\PurchasePayment();
@endphp

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Add Purchase Payment</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-md border border-red-300">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('purchase-payments.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Select Invoice</label>
                <select name="purchase_invoice_id" id="purchase_invoice_id" class="w-full p-2 border rounded-md bg-gray-50" required onchange="fetchInvoiceDetails(this.value)">
                    <option value="">-- Select Invoice --</option>
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->id }}" data-supplier="{{ $invoice->supplier_id }}">
                            {{ $invoice->invoice_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Select Supplier</label>
                <select name="supplier_id" id="supplier_id" class="w-full p-2 border rounded-md bg-gray-50" required>
                    <option value="">-- Select Supplier --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Invoice Date</label>
                <input type="date" id="invoice_date" name="invoice_date" class="w-full p-2 border rounded-md bg-gray-100" readonly>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Total Invoice Amount (₹)</label>
                <input type="number" id="total_amount" class="w-full p-2 border rounded-md bg-gray-100" readonly>
            </div>
        </div>

        <input type="hidden" name="round_off" id="round_off" value="{{ old('round_off', 0) }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Balance Due (₹)</label>
                <input type="number" id="balance_due" name="balance_due" class="w-full p-2 border rounded-md bg-gray-100" readonly>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Amount Paid (₹)</label>
                <input type="number" id="amount_paid" name="amount_paid" class="w-full p-2 border rounded-md" required oninput="updateBalanceDue()">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Payment Mode</label>
                <select name="payment_mode" class="w-full p-2 border rounded-md bg-gray-50" required>
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                    <option value="UPI">UPI</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Transaction ID (Optional)</label>
                <input type="text" name="transaction_id" class="w-full p-2 border rounded-md">
            </div>
        </div>

        <div>
            <label class="block font-semibold text-gray-700">Payment Status</label>
            <select name="status" class="w-full p-2 border rounded-md bg-gray-50" required>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
            </select>
        </div>

        <div class="mt-6 text-right">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 transition">Save Payment</button>
        </div>
    </form>
</div>
<script>

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("select[name='purchase_invoice_id']").addEventListener("change", function () {
        fetchInvoiceDetails(this.value);
    });

    document.querySelector("input[name='amount_paid']").addEventListener("input", function () {
        updateBalanceDue();
    });
});

function fetchInvoiceDetails(invoiceId) {
    if (!invoiceId) {
        clearFields();
        return;
    }

    fetch(`/get-purchase-invoice-details/${invoiceId}`)
        .then(response => response.json())
        .then(data => {
            if (data.invoice) {
                document.getElementById("invoice_date").value = data.invoice.invoice_date;
                document.getElementById("supplier_id").value = data.invoice.supplier_id;
                document.getElementById("total_amount").value = data.invoice.total_amount;
                document.getElementById("round_off").value = data.invoice.round_off;
                document.getElementById("balance_due").value = data.invoice.balance_due;
            } else {
                clearFields();
            }
        })
        .catch(error => {
            console.error("Error fetching invoice:", error);
        });
}

function updateBalanceDue() {
    let totalAmount = parseFloat(document.getElementById("total_amount").value) || 0;
    let amountPaid = parseFloat(document.querySelector("input[name='amount_paid']").value) || 0;
    let roundOff = parseFloat(document.getElementById("round_off").value) || 0;

    let newBalanceDue = totalAmount - amountPaid + roundOff;

    if (newBalanceDue < 0) {
        newBalanceDue = 0;
    }

    document.getElementById("balance_due").value = newBalanceDue.toFixed(2);
}

function clearFields() {
    document.getElementById("invoice_date").value = "";
    document.getElementById("supplier_id").value = "";
    document.getElementById("total_amount").value = "";
    document.getElementById("round_off").value = "";
    document.getElementById("balance_due").value = "";
}
</script>

@endsection
    {{-- <input type="number" id="round_off" class="form-control" readonly> --}}
