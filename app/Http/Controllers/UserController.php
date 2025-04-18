<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller {
public function index() {
    if (!auth()->user()->can('has-permission', 'Manage Users')) {
        abort(403, 'Unauthorized');
    }

    $users = User::all();
    return view('users.index', compact('users'));
}

    public function create() {
        return view('users.create');
    }


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|in:Admin,Manager,Accountant,Sales',
        'status' => 'required|boolean',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'status' => $request->status,
    ]);

    return redirect()->route('settings.index')->with('success', 'User created successfully!');
}

    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'role' => 'required|in:Admin,Manager,Accountant,Sales',
            'status' => 'required|in:Active,Inactive',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

public function assignRole(Request $request, $id)
{
    $user = User::findOrFail($id);
    $role = Role::findByName($request->role);
    $user->assignRole($role);

    return back()->with('success', 'Role assigned successfully');
}
    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

public function assignPermissions(Request $request, User $user) {
        $this->authorize('admin-only');

        $user->permissions()->sync($request->permissions ?? []);
        return redirect()->route('settings.index')->with('success', 'Permissions updated successfully.');
    }
}
