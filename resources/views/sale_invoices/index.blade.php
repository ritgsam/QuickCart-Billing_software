
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4"><b>Sale Invoices</b></h1>

    <form action="{{ route('sale_invoices.index') }}" method="GET" class="mb-4 p-3 border rounded" style="background-color: transparent;">
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
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

        <a href="{{ route('sale_invoices.create') }}" class="btn btn-dark mb-3">+ Create Invoice</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Invoice No</th>
                    <th>Customer</th>
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
                        <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                        <td>{{ $invoice->items->sum('sgst') }}%</td>
                        <td>{{ $invoice->items->sum('cgst') }}%</td>
                        <td>{{ $invoice->items->sum('igst') }}%</td>
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
                            <a href="{{ route('sale_invoices.show', $invoice->id) }}" class="btn btn-sm btn-dark">View</a>
                            {{-- @can('edit sale_invoices') --}}
                                <a href="{{ route('sale_invoices.edit', $invoice->id) }}" class="btn btn-sm btn-dark">Edit</a>
                            {{-- @endcan --}}
                            <a href="{{ route('sale_invoices.pdf', $invoice->id) }}" class="btn btn-sm btn-dark">PDF</a>
                            {{-- @can('delete sale_invoices') --}}
                                <form action="{{ route('sale_invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
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
