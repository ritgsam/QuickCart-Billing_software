@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
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

            <div>
                <label class="block font-semibold">Select Supplier:</label>
                <select name="supplier_id" class="w-full p-2 border rounded bg-white focus:ring focus:ring-blue-200" required>
                    <option value="">-- Choose a Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold">Select Purchase Invoice:</label>
                <select name="purchase_invoice_id" class="w-full p-2 border rounded bg-white focus:ring focus:ring-blue-200" required>
                    <option value="">-- Choose an Invoice --</option>
                    @foreach($purchaseInvoices as $invoice)
                        <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold">Debit Date:</label>
                <input type="date" name="debit_date" class="w-full p-2 border rounded bg-white focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block font-semibold">Total Amount:</label>
                <input type="number" name="total_amount" class="w-full p-2 border rounded bg-white focus:ring focus:ring-blue-200" step="0.01" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
                 Save Debit Note
            </button>
        </form>
    </div>
</div>
@endsection
