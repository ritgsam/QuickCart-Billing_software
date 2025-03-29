@extends('layouts.app')

@section('content')
<div class="container">
    <h2><b>Edit User</b></h2>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label>Role:</label>
            <select name="role" class="form-control" required>
                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Manager" {{ $user->role == 'Manager' ? 'selected' : '' }}>Manager</option>
                <option value="Accountant" {{ $user->role == 'Accountant' ? 'selected' : '' }}>Accountant</option>
                <option value="Sales" {{ $user->role == 'Sales' ? 'selected' : '' }}>Sales</option>
            </select>
        </div>
        <button type="submit" class="btn text-white" style="background-color: rgba(43, 42, 42, 0.694);">Update</button>
    </form>
</div>
@endsection
