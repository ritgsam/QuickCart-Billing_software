@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4"><b>Purchase Invoices</b></h1>
<form action="{{ route('purchase_invoices.index') }}" method="GET" class="mb-4 p-3 border rounded" style="background-color: transparent;">
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Start Date:</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}"
                @role('Manager') disabled @endrole>
        </div>
        <div class="col-md-3">
            <label class="form-label">End Date:</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}"
                @role('Manager') disabled @endrole>
        </div>
        <div class="col-md-3">
            <label class="form-label">Supplier:</label>
            <select name="supplier_id" class="form-select" @role('Manager') disabled @endrole>
                <option value="">All Suppliers</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->company_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Payment Status:</label>
            <select name="payment_status" class="form-select" @role('Manager') disabled @endrole>
                <option value="">All</option>
                <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Unpaid" {{ request('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                <option value="Partial" {{ request('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
            </select>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary"
            @role('Manager') disabled @endrole>Filter</button>
    </div>
</form>

    {{-- @can('create purchase_invoices') --}}
        <a href="{{ route('purchase_invoices.create') }}" class="btn btn-dark mb-3">+ Create Invoice</a>
    {{-- @endcan --}}

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Invoice No</th>
                    <th>Supplier</th>
                    <th>SGST %</th>
                    <th>CGST %</th>
                    <th>IGST %</th>
                    <th>Discount (%)</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->supplier->company_name ?? 'N/A' }}</td>
<td>{{ number_format($invoice->sgst_total, 2) }} ₹</td>
<td>{{ number_format($invoice->cgst_total, 2) }} ₹</td>
<td>{{ number_format($invoice->igst_total, 2) }} ₹</td>

                        <td>{{ $invoice->items->sum('discount') }}%</td>
                        <td>₹{{ number_format($invoice->final_amount, 2) }}</td>
<td>
    <span class="badge
        @if($invoice->payment_status == 'Paid') bg-success
        @elseif($invoice->payment_status == 'Partial') bg-warning
        @else bg-danger @endif">
        {{ ucfirst($invoice->payment_status) }}
    </span>
</td>

                        <td>
                            <a href="{{ route('purchase_invoices.show', $invoice->id) }}" class="btn btn-sm btn-dark">View</a>
                            @can('edit purchase_invoices')
                                <a href="{{ route('purchase_invoices.edit', $invoice->id) }}" class="btn btn-sm btn-dark">Edit</a>
                            @endcan
                            <a href="{{ route('purchase_invoices.pdf', $invoice->id) }}" class="btn btn-sm btn-dark">PDF</a>
                            {{-- @can('delete purchase_invoices') --}}
                                <form action="{{ route('purchase_invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this invoice?')">Delete</button>
                                </form>
                            {{-- @endcan --}}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center">No invoices found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $invoices->links() }}
</div>
@endsection
