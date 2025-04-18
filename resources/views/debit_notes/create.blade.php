@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto p-6 rounded-lg shadow-lg" style="background-color: #f5ebe0;">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-700"> Create Debit Note</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('debit_notes.store') }}" method="POST" class="space-y-4">
            @csrf
           <div class="form-group">
    <label class="block font-semibold" for="supplier_id">Select Supplier:</label>
    <select name="supplier_id" id="supplier_id" class="form-control" required>
    <option value="">-- Choose Supplier --</option>
    @foreach($suppliers as $supplier)
        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
    @endforeach
</select>
</div>
                        <div class="form-group">
                <label for="purchase_invoice_number">Purchase Invoice Number:</label>
                <input type="text" id="purchase_invoice_number" class="form-control" readonly>
                <input type="hidden" name="purchase_invoice_id" id="purchase_invoice_id">
            </div>
            <div>
                <label class="block font-semibold">Debit Date:</label>
                <input type="date" name="debit_date" class="w-full p-2 border rounded bg-white focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block font-semibold">Total Amount:</label>
                <input type="number" name="total_amount" class="w-full p-2 border rounded bg-white focus:ring focus:ring-blue-200" step="0.01" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition" style="background-color: rgba(43, 42, 42, 0.694);">
                Save Debit Note
            </button>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#supplier_id').on('change', function () {
            let supplierId = $(this).val();

            $('#purchase_invoice_number').val('');
            $('#purchase_invoice_id').val('');

            if (supplierId) {
                $.ajax({
                    url: `/get-supplier-invoice/${supplierId}`,
                    type: 'GET',
                    success: function (response) {
                        if (response && response.invoice) {
                            $('#purchase_invoice_number').val(response.invoice.invoice_number);
                            $('#purchase_invoice_id').val(response.invoice.id);
                        } else {
                            $('#purchase_invoice_number').val('No invoice found');
                        }
                    },
                    error: function () {
                        $('#purchase_invoice_number').val('Error fetching invoice');
                    }
                });
            }
        });
    });
</script>


@endsection
