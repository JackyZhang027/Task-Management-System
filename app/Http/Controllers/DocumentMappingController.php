<?php

namespace App\Http\Controllers;

use App\Models\DocumentMapping;
use App\Models\ProcessCategory;
use App\Models\services;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
//return type View
use Illuminate\View\View;

class DocumentMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index(): View
     {
         $documents = DocumentMapping::with('service')->paginate(10); 
         // render view
         return view('documents.index',compact('documents'))
             ->with('i', (request()->input('page', 1) - 1) * 5);
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = services::pluck('name', 'id');
        $categories = ProcessCategory::pluck('name', 'id');
        // render view
        return view('documents.create', ['services' => $services, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
         // validate request
         $request->validate([
            'service_id'     => 'required',
            'process_id'     => 'required',
            'name'     => 'required',
            'description'   => 'required',
            'sequence_no'     => 'required',
        ]);

        // insert new post to db
        DocumentMapping::create([
            'service_id' => $request->service_id,
            'process_id' => $request->process_id,
            'name' => $request->name,
            'description' => $request->description,
            'sequence_no' => $request->sequence_no,
            'is_active' => 1
        ]);

        // render view
        return redirect()->route('documents.index')
            ->with('success','Documents Mapping created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentMapping $documentMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $documents = DocumentMapping::findOrFail($id);
        $services = services::pluck('name', 'id');
        $categories = ProcessCategory::pluck('name', 'id');
        // render view
        return view('documents.edit', ['documents' => $documents, 'services' => $services, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'service_id'   => 'required',
            'process_id'   => 'required',
            'name'         => 'required',
            'description'  => 'required',
            'sequence_no'  => 'required',
        ]);

        // Find the document mapping record by ID
        $documentMapping = DocumentMapping::find($id);

        // Update the fields with the new values
        $documentMapping->update([
            'service_id'   => $request->service_id,
            'process_id'   => $request->process_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'sequence_no'  => $request->sequence_no,
            // You may want to update other fields as needed
        ]);

        // Render view with success message
        return redirect()->route('documents.index')
            ->with('success', 'Documents Mapping updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentMapping $documentMapping)
    {
        //
    }
}
