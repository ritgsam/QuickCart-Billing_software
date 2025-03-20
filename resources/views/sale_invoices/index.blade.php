@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4"><b>Sales Invoices</b></h1>

    <form action="{{ route('sale_invoices.index') }}" method="GET" class="mb-4 p-3 border rounded bg-light">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Start Date:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">End Date:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Customer:</label>
                <select name="customer_id" class="form-select">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Payment Status:</label>
                <select name="payment_status" class="form-select">
                    <option value="">All</option>
                    <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Unpaid" {{ request('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="Partial" {{ request('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <form action="{{ route('sale_invoices.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search_invoice" class="form-control" placeholder="Search by Invoice Number..." value="{{ request('search_invoice') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </div>
    </form>

    <a href="{{ route('sale_invoices.create') }}" class="btn btn-success mb-3">+ Create Invoice</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Invoice No</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>GST (%)</th>
                    <th>Discount (%)</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($saleInvoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number ?? 'N/A' }}</td>
                        <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                        <td>₹{{ number_format($invoice->total_amount, 2) }}</td>
                        <td>
                            @if($invoice->items->count() > 0)
                                {{ number_format($invoice->items->avg('gst_rate'), 2) }}%
                            @else
                                0%
                            @endif
                        </td>
                        <td>
                            @if($invoice->items->count() > 0)
                                {{ number_format($invoice->items->avg('discount'), 2) }}%
                            @else
                                0%
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $invoice->payment_status == 'Paid' ? 'bg-success' : ($invoice->payment_status == 'Unpaid' ? 'bg-danger' : 'bg-warning') }}">
                                {{ ucfirst($invoice->payment_status) }}
                            </span>
                        </td>
                        <td>
    <a href="{{ route('sale_invoices.show', $invoice->id) }}" class="btn btn-info btn-sm mx-1">View</a>
    <a href="{{ route('sale_invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm mx-1">Edit</a>
    <a href="{{ route('sale_invoices.download', $invoice->id) }}" class="btn btn-success btn-sm mx-1">Download PDF</a>
    <form action="{{ route('sale_invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm mx-1">Delete</button>
    </form>
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
