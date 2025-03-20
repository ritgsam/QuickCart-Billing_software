@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Supplier</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-700 p-3 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block">Company Name:</label>
            <input type="text" name="company_name" value="{{ $supplier->company_name }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" name="email" value="{{ $supplier->email }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Phone:</label>
            <input type="text" name="phone" value="{{ $supplier->phone }}" class="w-full p-2 border rounded">
        </div>

        <div class="col-md-12">
    <label class="form-label">Address:</label>
    <textarea name="address" class="form-control" rows="3" required>{{ $supplier->address }}</textarea>
</div>


        <div class="mb-4">
            <label class="block">GST Number:</label>
            <input type="text" name="gst_number" value="{{ $supplier->gst_number }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Payment Terms:</label>
            <input type="text" name="payment_terms" value="{{ $supplier->payment_terms }}" class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
