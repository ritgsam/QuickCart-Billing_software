@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Add Supplier</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-700 p-3 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block">Company Name:</label>
            <input type="text" name="company_name" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" name="email" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Phone:</label>
            <input type="text" name="phone" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Address:</label>
            <textarea name="address" class="w-full p-2 border rounded"></textarea>
        </div>

        <div class="mb-4">
            <label class="block">GST Number:</label>
            <input type="text" name="gst_number" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Payment Methods:</label>
            <input type="text" name="payment_terms" class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
@endsection
