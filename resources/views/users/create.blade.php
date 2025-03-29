@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto p-6 rounded-lg shadow-lg" style="background-color: #f5ebe0;">
        <h2 class="text-2xl font-bold mb-4 text-center">Create User</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold">Name:</label>
                <input type="text" name="name" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Email:</label>
                <input type="email" name="email" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Password:</label>
                <input type="password" name="password" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Confirm Password:</label>
                <input type="password" name="password_confirmation" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Role:</label>
                <select name="role" class="w-full p-2 border rounded">
                    <option value="Admin">Admin</option>
                    <option value="Manager">Employee</option>
                    <option value="Accountant"></option>
                    <option value="Sales"></option>
                </select>
            </div>

            <div>
                <label class="block font-semibold">Status:</label>
                <select name="status" class="w-full p-2 border rounded">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" style="background-color: rgba(43, 42, 42, 0.694);">Create User</button>
            </div>
        </form>
    </div>
</div>
@endsection
