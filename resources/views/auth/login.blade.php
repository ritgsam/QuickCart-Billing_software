
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100" >
    <div class="card shadow-lg border-0 p-4" style=" width: 400px; height: 9cm; background-color: rgba(43, 42, 42, 0.694);"
        {{-- <div class="card-header bg-primary text-white text-center">
            <h4>Login</h4>
        </div> --}}
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <input type="checkbox" name="remember"> Remember Me
                    </div>
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
