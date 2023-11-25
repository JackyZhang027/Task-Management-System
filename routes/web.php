<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Services Routes
Route::resource('/services', \App\Http\Controllers\ServicesController::class);

//Proposal Routes
Route::resource('proposal', \App\Http\Controllers\ProposalController::class);
Route::get('/generate-pdf/{id}', [\App\Http\Controllers\ProposalController::class, 'generatePDF'])->name('proposal.generatePDF');

Route::get('/request/{id}', [\App\Http\Controllers\ProposalController::class, 'request_data'])->name('proposal.request_data');
Route::put('/request-status/{id}', [\App\Http\Controllers\ProposalController::class, 'updateRequestStatus'])->name('request.update.status');
Route::patch('/request-status/{id}', [\App\Http\Controllers\ProposalController::class, 'updateRequestStatus'])->name('request.update.status');
Route::get('/process/{id}', [\App\Http\Controllers\ProposalController::class, 'process_data'])->name('proposal.process_data');
Route::patch('/request-update-transactions', [\App\Http\Controllers\ProposalController::class, 'updateTransactions'])->name('request.update.transactions');


//Company Routes
Route::resource('/company', \App\Http\Controllers\CompanyController::class);
//Location Routes
Route::resource('/location', \App\Http\Controllers\LocationController::class);


//Document Mapping Routes
Route::resource('/documents', \App\Http\Controllers\DocumentMappingController::class);

