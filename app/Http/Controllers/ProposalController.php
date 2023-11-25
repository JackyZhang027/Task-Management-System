<?php

namespace App\Http\Controllers;

use App\Models\DocumentMapping;
use App\Models\Proposal;
use App\Models\Company;
use App\Models\Location;
use App\Models\ProposalProcessTransaction;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Shared\ZipArchive; // Import ZipArchive
use PhpOffice\PhpWord\Settings;

use PhpOffice\PhpWord\IOFactory;



class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proposals = Proposal::with([
            'location',
            'company'
        ])->paginate(10);

        // Calculate the sum of 'Fee' for each proposal
        $proposals->each(function ($proposal) {
            $proposal->totalFee = $proposal->services->sum('Fee');
        });
        // render view
        return view('proposal.index',compact('proposals'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $companies = Company::pluck('name', 'id');
        $locations = Location::pluck('name', 'id');
        $services = Services::pluck('name', 'id');
        // render view
        return view('proposal.create', ['companies' => $companies, 'locations'=> $locations, 'services' => $services]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Use Laravel's DB transaction to wrap the database operations
        DB::beginTransaction();

        try {
            // Validate the form data
            $request->validate([
                'invoice_no' => 'required|unique:proposals',
                'date' => 'required',
                'company_id' => 'required',
                'location_id' => 'required',
            ]);

            // Create a new Proposal instance
            $proposal = new Proposal();
            $proposal->invoice_no = $request->input('invoice_no');
            $proposal->date = $request->input('date');
            $proposal->company_id = $request->input('company_id');
            $proposal->location_id = $request->input('location_id');
            $proposal->process_id = 1;
            $proposal->process_state_id = 1;

            // Save the Proposal to the database
            $proposal->save();

            $selectedServices = $request->input('services');
            $fees = $request->input('fees');

            foreach ($selectedServices as $serviceId => $isChecked) {
                if ($isChecked) {
                    $service = Services::find($serviceId);
                    if ($service) {
                         // Debugging: Log the service information
                        Log::info('Service ID: ' . $service->id);
                        Log::info('Service Name: ' . $service->name);

                        // Create a new ProposalService and associate it with the Proposal
                        $proposal->services()->create([
                            'service_id' => $service->id,
                            'fee' => $fees[$serviceId],
                        ]);
                        
                    }
                }
            }

            // If everything is successful, commit the transaction
            DB::commit();

            // Redirect back or to a success page
            return redirect()->route('proposal.create')->with('success', 'Proposal created successfully');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollback();

            // Redirect back with an error message or handle the exception as needed
            return redirect()->route('proposal.create')->with('error', 'Error creating proposal: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proposal = Proposal::findOrFail($id);
        $companies = Company::pluck('name', 'id');
        $locations = Location::pluck('name', 'id');
        $services = Services::all();
        return view('proposal.edit', compact('proposal', 'companies', 'locations', 'services'));
       // return view('proposal.create', ['proposal' => $proposal, 'companies' => $companies, 'locations'=> $locations, 'services' => $services]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Use Laravel's DB transaction to wrap the database operations
        DB::beginTransaction();

        try {
            // Validate the form data
            $request->validate([
                'invoice_no' => 'required|unique:proposals',
                'date' => 'required',
                'company_id' => 'required',
                'location_id' => 'required',
            ]);

            // Find the existing Proposal instance
            $proposal = Proposal::find($id);

            // Update the Proposal properties
            $proposal->invoice_no = $request->input('invoice_no');
            $proposal->date = $request->input('date');
            $proposal->company_id = $request->input('company_id');
            $proposal->location_id = $request->input('location_id');

            // Save the updated Proposal to the database
            $proposal->save();

            // Clear existing proposal services for the updated proposal
            $proposal->services()->delete();

            $selectedServices = $request->input('services');
            $fees = $request->input('fees');

            foreach ($selectedServices as $serviceId => $isChecked) {
                if ($isChecked) {
                    // Find or create the service
                    $service = Services::find($serviceId) ?? new Services;
            
                    // Update or create the ProposalService
                    $proposal->services()->updateOrCreate(
                        ['service_id' => $service->id],
                        ['fee' => $fees[$serviceId]]
                    );
                }
            }
            

            // If everything is successful, commit the transaction
            DB::commit();

            // Redirect back or to a success page
            return redirect()->route('proposal.index')->with('success', 'Proposal updated successfully');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollback();

            // Redirect back with an error message or handle the exception as needed
            return redirect()->route('proposal.edit', $id)->with('error', 'Error updating proposal: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generatePDF($id)
    {
        Settings::setZipClass(Settings::PCLZIP);
        
        $templatePath = public_path('files/template.docx');
        $outputPath = public_path('files/test.docx');
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        $templateProcessor->saveAs($outputPath);   
    }

    public function process_data($id)
    {
        $proposal = Proposal::findOrFail($id);

        // Update the Proposal States
        $proposal->process_id = 2;
        $proposal->process_state_id = 3;
        $proposal->save();

        $services = $proposal->services;
        $proposalTransactions = [];

        $companies = Company::pluck('name', 'id');
        $locations = Location::pluck('name', 'id');
        $services = Services::all();
        return view('request.process', compact('proposal', 'companies', 'locations', 'services'));
    }
    public function request_data($id)
    {
        $proposal = Proposal::findOrFail($id);

        // Update the Proposal States
        $proposal->process_state_id = 2;
        $proposal->save();

        $services = $proposal->services;
        $proposalTransactions = [];

        // Loop through the services
        foreach ($services as $service) {
            $mapping = $service->service->mappings;
            // Loop through the mapping
            foreach ($mapping as $item) {
                $existingTransaction = ProposalProcessTransaction::where([
                    'proposal_id' => $proposal->id,
                    'service_id' => $service->service->id,
                    'services_mapping_id' => $item->id,
                ])->first();
                if (!$existingTransaction) {
                    $proposalTransactions[] = [
                        'proposal_id' => $proposal->id,
                        'service_id' => $service->service->id,
                        'services_mapping_id' => $item->id,
                    ];
                }
            }
        }

        // Bulk insert the proposal transactions
        ProposalProcessTransaction::insert($proposalTransactions);
                        
        $companies = Company::pluck('name', 'id');
        $locations = Location::pluck('name', 'id');
        $services = Services::all();
        return view('request.data', compact('proposal', 'companies', 'locations', 'services'));
    }    

    public function updateTransactions(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        foreach ($request->input('transactions', []) as $transactionId => $transactionData) {
            // Find the transaction in the database
            $transaction = ProposalProcessTransaction::find($transactionId);

            // Ensure 'is_checked' key exists and set a default value if it doesn't
            $is_checked = isset($transactionData['is_checked']) ? ($transactionData['is_checked'] === 'on') : false;

            // Remove 'is_checked' from the array to avoid database errors
            unset($transactionData['is_checked']);

            // Compare the current 'is_checked' value in the database with the new value
            if ($transaction->is_checked !== (int)$is_checked) {
                $transactionData['is_checked'] = $is_checked;
                $transactionData['checked_by'] = $user->id; // Set 'checked_by' to the current user's ID
                $transactionData['checked_date'] = now(); // Set 'checked_date' to the current datetime
            }
            
            $transaction->update($transactionData);
        }

        return redirect()->back()->with('success', 'Transactions updated successfully.');
    }
    public function updateRequestStatus(Request $request, $id)
    {
        $proposal = Proposal::findOrFail($id);

        // Update the Proposal States
        $proposal->process_id = 2;
        $proposal->process_state_id = 3;
        $proposal->save();

        $message = 'Status has been updated.';
        if ($request->ajax()) {
            return response()->json(['message' => $message], 200);

        }
    
        return redirect()->back()->with('success', $message);
    }

}

