<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::latest()->paginate(10);
        return view('location.index', compact('locations'));
    }

    public function create()
    {
        return view('location.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|unique:location'
        ]);

        // insert new post to db
        Location::create([
            'name' => $request->name,
            'is_active' => 1
        ]);

        // render view
        return redirect()->route('location.index')
            ->with('success','Location created successfully.');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('location.edit', compact('location'));
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:location',
        ]);
        
        $location->update([
            'name' => $request->name,
            'is_active' =>  $request->has('is_active') ? 1 : 0,
        ]);
        
        return redirect()->route('location.index')->with('success', 'Location updated successfully');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        
        return redirect()->route('location.index')->with('success', 'Location deleted successfully');
    }

}
