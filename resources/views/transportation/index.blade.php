@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2><b>Transportations</b></h2><br>
    <a href="{{ route('transportations.create') }}" class="btn btn-primary mb-3">+ Add Transportation</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Customer</th>
                <th>Transporter</th>
                <th>Vehicle No</th>
                <th>Dispatch Date</th>
                <th>Expected Delivery</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transportations as $transport)
                <tr>
                    <td>{{ $transport->id }}</td>
                    <td>{{ $transport->saleInvoice->invoice_number }}</td>
                    <td>{{ $transport->saleInvoice->customer->name ?? 'N/A' }}</td>
                    <td>{{ $transport->transporter_name }}</td>
                    <td>{{ $transport->vehicle_number }}</td>
                    <td>{{ $transport->dispatch_date }}</td>
                    <td>{{ $transport->expected_delivery_date }}</td>
                    <td>{{ $transport->status }}</td>
                    <td>
                        <a href="{{ route('transportations.show', $transport->id) }}" class="btn btn-sm btn-dark">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
