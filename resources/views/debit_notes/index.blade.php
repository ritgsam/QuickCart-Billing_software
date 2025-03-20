@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"> Debit Notes</h4>
            <a href="{{ route('debit_notes.create') }}" class="btn btn-light fw-bold">+ Create Debit Note</a>
        </div>

        <div class="card-body bg-light">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Supplier</th>
                            <th>Purchase Invoice</th>
                            <th>Date</th>
                            <th>Total Amount (₹)</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($debitNotes as $note)
                            <tr>
                                <td>{{ $note->id }}</td>
                                <td>{{ optional($note->supplier)->company_name ?? 'No Supplier' }}</td>
                                <td>{{ optional($note->purchaseInvoice)->invoice_number ?? 'No Invoice' }}</td>
                                <td>{{ $note->debit_date }}</td>
                                <td>₹{{ number_format($note->total_amount, 2) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('debit_notes.edit', $note->id) }}" class="btn btn-warning btn-sm">
                                         Edit
                                    </a>
                                    <form action="{{ route('debit_notes.destroy', $note->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this Debit Note?');">
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
