@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Country</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('countries.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Country Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>

<div class="mb-3">
    <label for="iso_code" class="form-label">ISO Code</label>
    {{-- <input type="text" name="iso_code" id="iso_code" class="form-control" required> --}}
<input type="text" name="iso_code" class="form-control" placeholder="ISO Code (e.g., IN)" required>
</div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
