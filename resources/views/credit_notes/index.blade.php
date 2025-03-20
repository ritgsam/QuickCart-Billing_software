@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"> Credit Notes</h4>
            <a href="{{ route('credit_notes.create') }}" class="btn btn-light fw-bold">+ Add Credit Note</a>
        </div>

        <div class="card-body bg-light">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Total Amount (₹)</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
@foreach ($creditNotes as $creditNote)
<tr>
    <td>{{ $creditNote->saleInvoice->invoice_number ?? 'N/A' }}</td>
    <td>{{ $creditNote->saleInvoice->customer->name ?? 'N/A' }}</td>
    <td>₹{{ number_format($creditNote->total_amount, 2) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('credit_notes.show', $creditNote->id) }}" class="btn btn-info btn-sm">
                                         View
                                    </a>
                                    <a href="{{ route('credit_notes.edit', $creditNote->id) }}" class="btn btn-warning btn-sm">
                                         Edit
                                    </a>
                                    <form action="{{ route('credit_notes.destroy', $creditNote->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                             Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
