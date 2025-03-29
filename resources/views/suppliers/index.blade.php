
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Suppliers</h4>
            <a href="{{ route('suppliers.create') }}" class="btn btn-light">+ Add Supplier</a>
        </div>

        <div class="card-body" style="background-color: #f5ebe0;">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                    <tr>
                        <td style="background-color: rgb(238, 231, 231)">{{ $supplier->company_name }}</td>
                        <td style="background-color: rgb(238, 231, 231)">{{ $supplier->email }}</td>
                        <td style="background-color: rgb(238, 231, 231)">{{ $supplier->phone }}</td>
                        <td style="background-color: rgb(238, 231, 231)">{{ $supplier->address }}</td>
                        <td class="text-center" style="background-color: rgb(238, 231, 231)">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm text-white" style="background-color: rgba(43, 42, 42, 0.694);">Edit</a>

                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
