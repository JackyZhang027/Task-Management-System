<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('company.index', compact('companies'));
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|unique:companies',
            'address'   => 'required'
        ]);

        // insert new post to db
        Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'is_active' => 1
        ]);

        // render view
        return redirect()->route('company.index')
            ->with('success','Company created successfully.');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, Company $company): RedirectResponse
    {
        $request->validate([
            'name'    => 'required|unique:companies',
            'address' => 'required',
        ]);
        
        $company->update([
            'name' => $request->name,
            'address' => $request->address,
            'is_active' =>  $request->has('is_active') ? 1 : 0,
        ]);
        
        return redirect()->route('company.index')->with('success', 'Company updated successfully');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        
        return redirect()->route('company.index')->with('success', 'Company deleted successfully');
    }

}
