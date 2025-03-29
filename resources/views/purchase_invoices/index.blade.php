@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4"><b>Purchase Invoices</b></h1>

    <a href="{{ route('purchase_invoices.create') }}" class="btn text-white mb-3" style="background-color: rgba(43, 42, 42, 0.694);">
        + Create Invoice
    </a>

    <form action="{{ route('purchase_invoices.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Supplier:</label>
                <select name="supplier_id" class="form-control" style="background-color: rgb(238, 231, 231)">
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
                <select name="payment_status" class="form-control" style="background-color: rgb(238, 231, 231)">
                    <option value="">All</option>
                    <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Unpaid" {{ request('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="Partial" {{ request('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="background-color: rgb(238, 231, 231)">
            </div>

            <div class="col-md-3">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="background-color: rgb(238, 231, 231)">
            </div>

            <div class="col-md-3">
                <label>Search Invoice:</label>
                <input type="text" name="search" class="form-control" placeholder="Invoice Number" value="{{ request('search') }}" style="background-color: rgb(238, 231, 231)">
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
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td style="background-color: rgb(238, 231, 231)">{{ $invoice->invoice_number }}</td>
                        <td style="background-color: rgb(238, 231, 231)">
                            {{ $invoice->supplier->company_name ?? 'N/A' }}
                        </td>
<td style="background-color: rgb(238, 231, 231)">
    {{ $invoice->items->sum('gst_rate') }}%
</td>
<td style="background-color: rgb(238, 231, 231)">
    {{ $invoice->items->sum('discount') }}%
</td>
                        
            <td style="background-color: rgb(238, 231, 231)">₹{{ number_format($invoice->final_amount, 2) }}</td>

                        <td style="background-color: rgb(238, 231, 231)">
                            <span class="badge
                                @if($invoice->payment_status == 'Paid') bg-success
                                @elseif($invoice->payment_status == 'Partial') bg-warning
                                @else bg-danger @endif">
                                {{ $invoice->payment_status }}
                            </span>
                        </td>
                        <td style="background-color: rgb(238, 231, 231)">
                            <a href="{{ route('purchase_invoices.show', $invoice->id) }}" class="btn text-white btn-sm" style="background-color: rgba(43, 42, 42, 0.694);">View</a>
                            <a href="{{ route('purchase_invoices.edit', $invoice->id) }}" class="btn text-white btn-sm" style="background-color: rgba(43, 42, 42, 0.694);">Edit</a>
                            <a href="{{ route('purchase_invoices.pdf', $invoice->id) }}" class="btn text-white btn-sm" style="background-color: rgba(43, 42, 42, 0.694);">Download PDF</a>
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