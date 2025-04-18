@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-1/4 shadow-lg rounded-lg p-4 text-center bg-gray-200">
            <div class="mb-4">
                @if(!empty($settings->company_logo))
                <div class="flex justify-center">
                    <img src="{{ asset($settings->company_logo) }}" alt="Company Logo" class="w-32 h-32 rounded shadow-md">
                </div>
                @else
                <p>Logo not uploaded</p>
                @endif
                <h2 class="text-lg font-semibold mt-2">{{ $settings->company_name ?? 'Your Company' }}</h2>
            </div>
            <nav class="space-y-2">
                <button class="w-full text-left px-4 py-2 rounded-lg bg-gray-600 hover:bg-blue-400 text-white" onclick="showSection('profile-settings')">Profile</button>
                <button class="w-full text-left px-4 py-2 rounded-lg bg-gray-600 hover:bg-blue-400 text-white" onclick="showSection('company-settings')">Company Settings</button>
                <button class="w-full text-left px-4 py-2 rounded-lg bg-gray-600 hover:bg-blue-400 text-white" onclick="showSection('user-management')">User & Role Management</button>
            </nav>
        </div>

        <div class="w-full md:w-3/4 shadow-lg rounded-lg p-6 bg-gray-200">
            <div id="profile-settings" class="settings-section">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Profile Settings</h2>
                <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-medium">Company Name</label>
                        <input type="text" class="w-full border rounded p-2" name="company_name" value="{{ $settings->company_name ?? '' }}">
                    </div>
                    <div>
                        <label class="block font-medium">Company Logo</label>
                        <input type="file" class="form-control" name="company_logo">
                    </div>
                    <div>
                        <label class="block font-medium">Address</label>
                        <input type="text" class="w-full border rounded p-2" name="company_address" value="{{ $settings->company_address ?? '' }}">
                    </div>
                    <div>
                        <label class="block font-medium">Contact Details</label>
                        <input type="text" class="w-full border rounded p-2" name="company_contact" value="{{ $settings->company_contact ?? '' }}">
                    </div>
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">Save Changes</button>
                </form>
            </div>

            <div id="company-settings" class="settings-section hidden">
                <h2 class="text-xl font-semibold mb-4">Company Settings</h2>
                <form action="{{ route('settings.updateCompany') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-medium">Business Name</label>
                        <input type="text" class="w-full border rounded p-2" name="business_name" value="{{ $settings->business_name ?? '' }}">
                    </div>
                    <div>
                        <label class="block font-medium">Business Address</label>
                        <input type="text" class="w-full border rounded p-2" name="business_address" value="{{ $settings->business_address ?? '' }}">
                    </div>
                    <div>
                        <label class="block font-medium">State</label>
                        <input type="text" class="w-full border rounded p-2" name="business_state" value="{{ $settings->business_state ?? '' }}">
                    </div>
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">Update Settings</button>
                </form>
            </div>
{{-- <div class="w-full md:w-3/4 shadow-lg rounded-lg p-6 animate-slide-in" style="background-color: rgb(238, 231, 231)"> --}}
            <div id="user-management" class="settings-section hidden">
                <h2 class="text-xl font-semibold mb-4">User & Role Management</h2>
                <div class="text-right mb-4">
                    <a href="{{ route('users.create') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-green-600">+ Add New User</a>
                </div>


                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 shadow-lg rounded-lg">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 border text-left">User Name</th>
                                <th class="p-3 border text-left">Email</th>
                                <th class="p-3 border text-left">Role</th>
                                <th class="p-3 border text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="text-center bg-white hover:bg-gray-50">
                                <td class="p-3 border text-left">{{ $user->name }}</td>
                                <td class="p-3 border text-left">{{ $user->email }}</td>

                                <td class="p-3 border text-left">
                                    <form action="{{ route('settings.updateRole', $user->id) }}" method="POST">
                                        @csrf
                                        <select name="role" class="border p-2 rounded w-full">
                                            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="Manager" {{ $user->role == 'Manager' ? 'selected' : '' }}>Manager</option>
                                            <option value="Accountant" {{ $user->role == 'Accountant' ? 'selected' : '' }}></option>
                                            <option value="Sales" {{ $user->role == 'Sales' ? 'selected' : '' }}></option>
                                        </select>
                                        <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded mt-2 w-full">Save</button>
                                    </form>
                                </td>

                                @php
                                    $userPermissions = is_string($user->permissions) ? json_decode($user->permissions, true) : $user->permissions ?? [];
                                @endphp
                                </td>

                                <td class="p-3 border text-center">
                                    <a href="{{ route('settings.deleteUser', $user->id) }}" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</a>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function showSection(sectionId) {
    document.querySelectorAll('.settings-section').forEach(section => {
        section.classList.add('hidden');
    });
    document.getElementById(sectionId).classList.remove('hidden');
}
</script>

<style>
.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 20px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #4CAF50;
}

input:checked + .slider:before {
    transform: translateX(20px);
}
</style>

@endsection
