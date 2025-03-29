
@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">Customers</h4>
            <a href="{{ route('customers.create') }}" class="btn btn-light">+ Add Customer</a>
        </div>

        <div class="card-body" style="background-color: #f5ebe0;">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr style="background-color: rgb(61, 60, 60);">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td style="background-color: rgb(238, 231, 231)">{{ $customer->name }}</td>
                        <td style="background-color: rgb(238, 231, 231)">{{ $customer->email }}</td>
                        <td style="background-color: rgb(238, 231, 231)">{{ $customer->phone }}</td>
                        <td style="background-color: rgb(238, 231, 231)">{{ $customer->address }}</td>
                        <td class="text-center" style="background-color: rgb(238, 231, 231)">
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm text-white" style="background-color: rgba(43, 42, 42, 0.694);">Edit</a>

                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
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
