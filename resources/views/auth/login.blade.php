@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Login</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-700 p-3 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" name="email" class="w-80 p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Password:</label>
            <input type="password" name="password" class="w-80 p-2 border rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
    </form>
</div>
@endsection
