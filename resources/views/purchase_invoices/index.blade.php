@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4"><b>Purchase Invoices</b></h1>

    <a href="{{ route('purchase_invoices.create') }}" class="btn btn-success mb-3">+ Create Invoice</a>

    <form action="{{ route('purchase_invoices.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Supplier:</label>
                <select name="supplier_id" class="form-control">
                    <option value="">All Suppliers</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Payment Status:</label>
                <select name="payment_status" class="form-control">
                    <option value="">All</option>
                    <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Unpaid" {{ request('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="Partial" {{ request('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3">
                <label>Search Invoice:</label>
                <input type="text" name="search" class="form-control" placeholder="Invoice Number" value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('purchase_invoices.index') }}" class="btn btn-secondary ms-2">Reset</a>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
        <th>Invoice No</th>
        <th>Supplier</th>
        <th>GST (%)</th>
        <th>Discount (%)</th>
        <th>Total Amount</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    @foreach ($invoices as $invoice)
    <tr>
        <td>{{ $invoice->invoice_number }}</td>
        <td>{{ $invoice->supplier->company_name }}</td>
        <td>{{ $invoice->items->first()->gst_rate }}%</td>
        <td>{{ $invoice->items->first()->discount }}%</td>
        <td>₹{{ number_format($invoice->total_amount, 2) }}</td>
        <td>
            <a href="{{ route('purchase_invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">View</a>
            <a href="{{ route('purchase_invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm">Edit</a>
   <a href="{{ route('purchase_invoices.pdf', $invoice->id) }}" class="btn btn-success btn-sm">Download PDF</a>
            <form action="{{ route('purchase_invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
