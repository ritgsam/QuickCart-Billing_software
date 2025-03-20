@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-700"> Add New Category</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold">Category Name:</label>
                    <input type="text" name="name" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" required>
                </div>

                <div>
                    <label class="block font-semibold">Status:</label>
                    <select name="status" class="w-full p-2 border rounded bg-white focus:ring focus:ring-blue-200" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-semibold">Description:</label>
                <textarea name="description" class="w-full p-2 border rounded focus:ring focus:ring-blue-200"></textarea>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                     Save Category
                </button>
                <a href="{{ route('categories.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
