@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Customers</h1>

    <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Add Customer</a>

    <table class="w-full mt-4 border bg-white">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Phone</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr class="border">
                <td class="px-4 py-2 border">{{ $customer->name }}</td>
                <td class="px-4 py-2 border">{{ $customer->email }}</td>
                <td class="px-4 py-2 border">{{ $customer->phone }}</td>
                <td class="px-4 py-2 border">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="text-yellow-600">Edit</a>

                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?');" class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
