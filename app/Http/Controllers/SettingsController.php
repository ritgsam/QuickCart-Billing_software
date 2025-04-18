<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use Spatie\Permission\Models\Role;


class SettingsController extends Controller {
public function index()
    {
        $settings = Setting::first();
        $users = User::all();
        return view('settings.index', compact('settings', 'users'));
    }
    public function updateProfile(Request $request)
{
   $settings = Setting::firstOrNew([]);

$settings->company_name = $request->company_name;
$settings->company_email = $request->company_email ?? 'default@example.com';
$settings->company_phone = $request->company_phone ?? '0000000000';
$settings->company_address = $request->company_address;
$settings->company_contact = $request->company_contact;

if ($request->hasFile('company_logo')) {
    $file = $request->file('company_logo');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads'), $filename);
    $settings->company_logo = 'uploads/' . $filename;
}

$settings->save();
return redirect()->back()->with('success', 'Profile updated successfully');
}

public function updateRole(Request $request, $id) {
    $user = User::findOrFail($id);
    $user->role = $request->role;
    $user->save();

    return redirect()->back()->with('success', 'User role updated successfully.');
}
    public function updateCompany(Request $request)
    {
        $settings = Setting::first() ?? new Setting();
        $settings->business_name = $request->business_name;
        $settings->business_address = $request->business_address;
        $settings->business_state = $request->business_state;

        if ($request->hasFile('business_logo')) {
            $file = $request->file('business_logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $settings->business_logo = $filename;
        }

        $settings->save();
        return redirect()->route('settings.index')->with('success', 'Company settings updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('settings.index')->with('success', 'User deleted successfully.');
    }

    public function addUser() {
    return view('settings.add_user');
}

public function updatePermissions(Request $request)
{
    $managerRole = Role::where('name', 'Manager')->first();

    if ($managerRole) {
        $managerRole->syncPermissions($request->permissions ?? []);
    }

    return redirect()->back()->with('success', 'Permissions updated successfully.');
}

    public function update(Request $request) {
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required|email',
            'company_phone' => 'required',
            'company_address' => 'required',
            'invoice_prefix' => 'required',
            'default_tax_rate' => 'required|numeric',
             'status' => 'boolean',
        ]);
$user = new User();
$user->status = $request->status === "Active" ? true : false;
$user->save();

        $settings = Setting::first();

    if (!$settings) {
        $settings = new Setting();
    }

    $settings->company_name = $request->company_name;
    $settings->company_address = $request->company_address;
    $settings->company_contact = $request->company_contact;

    if ($request->hasFile('company_logo')) {
        $file = $request->file('company_logo');
        $path = $file->store('logos', 'public');
        $settings->company_logo = $path;
    }

    $settings->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

}

