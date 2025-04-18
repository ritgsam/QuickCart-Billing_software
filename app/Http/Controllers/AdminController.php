<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
public function updatePermissions(Request $request)
{
    $user = User::findOrFail($request->user_id);
    $permission = Permission::findOrFail($request->permission_id);

    if ($request->is_checked == "true") {
        $user->givePermissionTo($permission);
    } else {
        $user->revokePermissionTo($permission);
    }

    return response()->json(['message' => 'Permission updated successfully.']);
}
public function settingsPage()
{
    $permissions = Permission::all(); 
    return view('settings.index', compact('permissions'));
}
}
