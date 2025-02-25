@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Customer</h1>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block">Name:</label>
            <input type="text" name="name" value="{{ $customer->name }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" name="email" value="{{ $customer->email }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Phone:</label>
            <input type="text" name="phone" value="{{ $customer->phone }}" class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
