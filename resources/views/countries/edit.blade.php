@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Country</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('countries.update', $country) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Country Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $country->name) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
