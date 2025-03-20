<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller {
    public function index() {
        $settings = Setting::first();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request) {
        $request->validate([
            'company_name' => 'required|string',
            'company_logo' => 'nullable|image|max:2048',
            'company_address' => 'nullable|string',
            'gst_number' => 'nullable|string',
            'invoice_prefix' => 'required|string',
            'invoice_terms' => 'nullable|string',
            'tax_rate' => 'required|numeric|min:0',
        ]);

        $settings = Setting::firstOrCreate([]);
        $settings->update($request->except('company_logo'));

        if ($request->hasFile('company_logo')) {
            $filePath = $request->file('company_logo')->store('logos', 'public');
            $settings->update(['company_logo' => $filePath]);
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}

