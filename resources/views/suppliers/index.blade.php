@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Suppliers</h1>

    <a href="{{ route('suppliers.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Add Supplier</a>

    <table class="w-full mt-4 border bg-white">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border">Company</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Phone</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
            <tr class="border">
                <td class="px-4 py-2 border">{{ $supplier->company_name }}</td>
                <td class="px-4 py-2 border">{{ $supplier->email }}</td>
                <td class="px-4 py-2 border">{{ $supplier->phone }}</td>
                <td class="px-4 py-2 border">
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-yellow-600">Edit</a>
                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
