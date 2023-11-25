<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
//return type View
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(): View
    {
        $services = Services::latest()->paginate(10);

        // render view
        return view('services.index',compact('services'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create(): View
    {
        // render view
        return view('services.create');
    }

    /**
     *  insert new post data
     */
    public function store(Request $request): RedirectResponse
    {
        // validate request
        $request->validate([
            'name'          => 'required|unique:services',
            'description'   => 'required'
        ]);

        // insert new post to db
        Services::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => 1
        ]);

        // render view
        return redirect()->route('services.index')
            ->with('success','Service created successfully.');
    }
     /**
     * Display the specified resource.
     */
    public function show(Services $service): View
    {
        return view('services.show',compact('service'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Services $service): View
    {
        return view('services.edit',compact('service'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Services $service): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:services',
            'description' => 'required',
        ]);
        
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' =>  $request->has('is_active') ? 1 : 0,
        ]);
        
        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $service)
    {
        $service->delete();
        
        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}
