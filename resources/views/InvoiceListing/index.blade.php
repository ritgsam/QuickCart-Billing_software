@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Sales Invoices</h1>

    <a href="{{ route('sale_invoices.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Create Invoice</a>

    <table class="w-full mt-4 border bg-white">
        <thead>
            <tr class="bg-gray-200">
                <th>Invoice Number</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->customer->name }}</td>
                <td>₹{{ $invoice->final_amount }}</td>
                <td>
                    <form action="{{ route('sale_invoices.destroy', $invoice->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
