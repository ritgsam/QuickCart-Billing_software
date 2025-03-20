@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Settings & Configuration</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Company Name:</label>
                <input type="text" name="company_name" class="form-control" value="{{ $settings->company_name ?? '' }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Company Logo:</label>
                <input type="file" name="company_logo" class="form-control">
                @if($settings && $settings->company_logo)
                    <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="Logo" width="100" class="mt-2">
                @endif
            </div>

            <div class="col-md-12">
                <label class="form-label">Company Address:</label>
                <textarea name="company_address" class="form-control">{{ $settings->company_address ?? '' }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">GST Number:</label>
                <input type="text" name="gst_number" class="form-control" value="{{ $settings->gst_number ?? '' }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Invoice Prefix:</label>
                <input type="text" name="invoice_prefix" class="form-control" value="{{ $settings->invoice_prefix ?? 'INV-' }}" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Invoice Terms & Conditions:</label>
                <textarea name="invoice_terms" class="form-control">{{ $settings->invoice_terms ?? '' }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tax Rate (%):</label>
                <input type="number" name="tax_rate" step="0.01" class="form-control" value="{{ $settings->tax_rate ?? '0' }}" required>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Save Settings</button>
        </div>
    </form>
</div>
@endsection
