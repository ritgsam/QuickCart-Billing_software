@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Record Sale Payment</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-md border border-red-300">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sale_payments.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Select Invoice</label>
                <select name="sale_invoice_id" id="sale_invoice_id" class="w-full p-2 border rounded-md bg-gray-50" required>
                    <option value="">-- Select Invoice --</option>
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->id }}">
                            {{ $invoice->invoice_number }} - {{ $invoice->customer->name ?? 'No Customer' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Customer</label>
                <input type="text" id="customer_name" class="w-full p-2 border rounded-md bg-gray-100" readonly>
                <input type="hidden" name="customer_id" id="customer_id">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Total Invoice Amount (₹)</label>
                <input type="number" id="total_invoice_amount" class="w-full p-2 border rounded-md bg-gray-100" readonly>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Amount Paid (₹)</label>
                <input type="number" step="0.01" id="amount_paid" name="amount_paid" class="w-full p-2 border rounded-md" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Balance Due (₹)</label>
                <input type="number" id="balance_due" class="w-full p-2 border rounded-md bg-gray-100" readonly>
            </div>
            {{-- <div>
                <label class="block font-semibold text-gray-700">Round Off</label>
                <input type="number" step="0.01" name="round_off" id="round_off" class="w-full p-2 border rounded-md bg-gray-100" readonly>
            </div> --}}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" class="w-full p-2 border rounded-md" required>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Payment Method</label>
                <select name="payment_method" class="w-full p-2 border rounded-md bg-gray-50" required>
                    <option value="">Select Payment Method</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="UPI">UPI</option>
                    <option value="PayPal">PayPal</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Transaction ID (Optional)</label>
                <input type="text" name="transaction_id" class="w-full p-2 border rounded-md">
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Payment Status</label>
                <select name="payment_status" id="payment_status" class="w-full p-2 border rounded-md bg-gray-50">
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                    <option value="Partial">Partial</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block font-semibold text-gray-700">Payment Mode</label>
            <select name="payment_mode" id="payment_mode" class="w-full p-2 border rounded-md bg-gray-50">
                <option value="Cash">Cash</option>
                <option value="Online">Online</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="UPI">UPI</option>
            </select>
        </div>

        <div class="mt-6 text-right">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 transition">Submit Payment</button>
        </div>
    </form>
</div>

<script>
function calculateRoundOff() {
        let invoice = document.getElementById("invoice_id");
        let selectedOption = invoice.options[invoice.selectedIndex];
        let actualAmount = parseFloat(selectedOption.getAttribute("data-amount")) || 0;

        let roundedAmount = Math.round(actualAmount);
        let roundOff = (roundedAmount - actualAmount).toFixed(2);

        document.getElementById("amount").value = roundedAmount;
        document.getElementById("round_off").value = roundOff;
    }
document.getElementById('sale_invoice_id').addEventListener('change', function () {
    let invoiceId = this.value;
    
    if (invoiceId) {
        fetch(`/sale-invoices/${invoiceId}/details`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('customer_id').value = data.customer_id;
                    document.getElementById('customer_name').value = data.customer_name;
                    document.getElementById('payment_status').value = data.payment_status;
                    document.getElementById('payment_mode').value = data.payment_mode;
                    
                    document.getElementById('total_invoice_amount').value = data.total_amount.toFixed(2);
                    document.getElementById('balance_due').value = data.balance_due.toFixed(2);
                    document.getElementById('round_off').value = data.round_off.toFixed(2);
                }
            })
            .catch(error => console.error('Error fetching invoice details:', error));
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let paymentDateInput = document.getElementById('payment_date');
    if (!paymentDateInput.value) {
        let today = new Date().toISOString().split('T')[0];
        paymentDateInput.value = today;
    }
});

document.getElementById('amount_paid').addEventListener('input', function () {
    let totalAmount = parseFloat(document.getElementById('total_invoice_amount').value) || 0;
    let amountPaid = parseFloat(this.value) || 0;

    let balanceDue = totalAmount - amountPaid;
    document.getElementById('balance_due').value = balanceDue.toFixed(2);
});


function calculateBalanceDue() {
    let totalAmount = parseFloat(document.getElementById('total_invoice_amount').value) || 0;
    let amountPaid = parseFloat(document.getElementById('amount_paid').value) || 0;
    
    let balanceDue = totalAmount - amountPaid;
    let roundOff = Math.round(balanceDue) - balanceDue;

    document.getElementById('balance_due').value = balanceDue.toFixed(2);
    document.getElementById('round_off').value = roundOff.toFixed(2);
}

document.getElementById('customer_id').addEventListener('change', function() {
    let customerId = this.value;
    if (customerId) {
        fetch(`/get-latest-invoice-date/${customerId}`)
            .then(response => response.json())
            .then(data => {
                if (data.invoice_date) {
                    document.getElementById('payment_date').value = data.invoice_date;
                } else {
                    document.getElementById('payment_date').value = ''; 
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('payment_date').value = ''; 
    }
});

</script>
@endsection