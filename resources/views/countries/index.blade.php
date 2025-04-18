@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Country List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('countries.create') }}" class="btn btn-primary mb-3">Add New Country</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Country Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($countries as $country)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $country->name }}</td>
                    <td>
                        <a href="{{ route('countries.edit', $country) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('countries.destroy', $country) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No countries found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
