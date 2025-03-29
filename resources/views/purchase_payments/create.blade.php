
@extends('layouts.app')
@php
    $purchasePayment = $purchasePayment ?? new \App\Models\PurchasePayment();
@endphp

@section('content')
<div class="container p-4">
    <h1 class="text-center fw-bold mb-4">Add Purchase Payment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('purchase-payments.store') }}">
        @csrf

        <div class="row g-3">

<div class="col-md-6">
    <label class="form-label fw-semibold">Select Invoice:</label>
    <select name="purchase_invoice_id" id="purchase_invoice_id" class="form-select" required onchange="fetchInvoiceDetails(this.value)">
        <option value="">-- Select Invoice --</option>
        @foreach ($invoices as $invoice)
            <option value="{{ $invoice->id }}" data-supplier="{{ $invoice->supplier_id }}">
                {{ $invoice->invoice_number }}
            </option>
        @endforeach
    </select>
</div>
<div class="col-md-6">
    <label class="form-label fw-semibold">Select Supplier:</label>
    <select name="supplier_id" id="supplier_id" class="form-select" required>
        <option value="">-- Select Supplier --</option>
        @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-6">
    <label class="form-label fw-semibold">Invoice Date:</label>
    <input type="date" id="invoice_date" name="invoice_date" class="form-control" readonly>
</div>

<div class="col-md-6">
    <label class="form-label fw-semibold">Total Invoice Amount (₹):</label>
    <input type="number" id="total_amount" class="form-control" readonly>
</div>

{{-- <div class="col-md-6">
    <label class="form-label fw-semibold">Round Off (₹):</label>
    <input type="number" id="round_off" class="form-control" readonly>
</div> --}}

<div class="col-md-6">
    <label class="form-label fw-semibold">Balance Due (₹):</label>
    <input type="number" id="balance_due" name="balance_due" class="form-control" readonly>
</div>

<div class="col-md-6">
    <label class="form-label fw-semibold">Amount Paid (₹):</label>
    <input type="number" id="amount_paid" name="amount_paid" class="form-control" required oninput="updateBalanceDue()">
</div>


            <div class="col-md-6">
                <label class="form-label fw-semibold">Payment Mode:</label>
                <select name="payment_mode" class="form-select" required>
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                    <option value="UPI">UPI</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Transaction ID (Optional):</label>
                <input type="text" name="transaction_id" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Payment Status:</label>
                <select name="status" class="form-select" required>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn text-white px-4" style="background-color: rgba(43, 42, 42, 0.694);">Save Payment</button>
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
