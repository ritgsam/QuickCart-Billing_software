<?php
namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('countries.index', compact('countries'));
    }

public function create()
{
    $countries = Country::all();
    $categories = Categories::all();

    return view('products.create', compact('countries', 'categories'));
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'iso_code' => 'required|string|max:10',
    ]);

    Country::create([
        'name' => $request->name,
        'iso_code' => $request->iso_code,
    ]);

    return redirect()->route('countries.index')->with('success', 'Country added successfully!');
}

    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $country->update(['name' => $request->name]);

        return redirect()->route('countries.index')->with('success', 'Country updated!');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted.');
    }
}
