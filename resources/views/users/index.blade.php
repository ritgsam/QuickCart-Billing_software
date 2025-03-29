@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: rgb(61, 60, 60);">
            <h4 class="mb-0">User Management</h4>
            <a href="{{ route('users.create') }}" class="btn btn-light">+ Add New User</a>
        </div>

        <div class="card-body"style="background-color: #f5ebe0;">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->last_login ? $user->last_login->format('d-m-Y H:i') : 'Never' }}</td>
                            <td>
                                <span class="badge {{ $user->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn text-white btn-sm mx-1" style="background-color: rgba(43, 42, 42, 0.694);">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
