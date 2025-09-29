<?php

use App\Http\Controllers\frontoffice\batchController;
use App\Http\Controllers\frontoffice\frontofficeController;
use App\Http\Controllers\frontoffice\FarmerController as FrontOfficeFarmerController;
use App\Http\Controllers\frontoffice\SampleController as FrontOfficeSampleController;
use App\Http\Controllers\frontoffice\PaymentController as FrontOfficePaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:front_office'])->prefix('frontoffice')->name('frontoffice.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [frontofficeController::class, 'index'])->name('dashboard');

    // Farmer Management
    Route::get('/farmers', [FrontOfficeFarmerController::class, 'index'])->name('farmers.index');
    Route::get('/farmers/create', [FrontOfficeFarmerController::class, 'create'])->name('farmers.create');
    Route::post('/farmers', [FrontOfficeFarmerController::class, 'store'])->name('farmers.store');
    Route::get('/farmers/{id}/edit', [FrontOfficeFarmerController::class, 'edit'])->name('farmers.edit');
    Route::post('/farmers/{id}', [FrontOfficeFarmerController::class, 'update'])->name('farmers.update');
    Route::get('/farmers/{id}/destroy', [FrontOfficeFarmerController::class, 'destroy'])->name('farmers.destroy');

    // Sample Management
    // Note: You will need to create a 'SampleController' inside the 'app/Http/Controllers/frontoffice' directory.
    Route::get('/samples', [FrontOfficeSampleController::class, 'index'])->name('samples.index');
    Route::get('/samples/create', [FrontOfficeSampleController::class, 'create'])->name('samples.create');
    Route::post('/samples', [FrontOfficeSampleController::class, 'store'])->name('samples.store');
    Route::get('/samples/track', [FrontOfficeSampleController::class, 'track'])->name('samples.track');
    Route::post('/samples/get-prices', [FrontOfficeSampleController::class, 'getPrices'])->name('samples.getPrices');
    Route::get('/samples/payment/{farmer_id}', [FrontOfficeSampleController::class, 'paymentShow'])->name('samples.paymentShow');
    Route::get('/samples/sample-type/{id}/data', [FrontOfficeSampleController::class, 'getSampleTypeData'])->name('samples.getSampleTypeData');

    // Payment/Paid Samples
    // Note: You will need to create a 'PaymentController' inside the 'app/Http/Controllers/frontoffice' directory.
    // Route::get('/payments/paid', [FrontOfficePaymentController::class, 'paid'])->name('payments.paid');

    // Accept samples
    Route::get('/samples/accept', [FrontOfficeSampleController::class, 'acceptIndex'])->name('samples.accept');
    Route::post('/samples/accept', [FrontOfficeSampleController::class, 'acceptSample'])->name('samples.accept.process');
    // Reject sample
    Route::post('/samples/reject/{id}', [FrontOfficeSampleController::class, 'rejectSample'])
        ->name('samples.reject');
    // Route::get('/create-batch', [FrontOfficeSampleController::class, 'createBatch'])->name('batches.create');
    // Manually create batch route
    Route::get('/all-batches', [FrontOfficeSampleController::class, 'allBatch'])->name('all-batches');
    Route::get('/batches', [FrontOfficeSampleController::class, 'batch'])->name('batches');
    Route::post('/batches/create', [FrontOfficeSampleController::class, 'createBatch'])->name('batches.create');

    Route::get('/batches/{batch}/view', [BatchController::class, 'batchView'])->name('batches.view');
    Route::get('/batches/{batch}/parameters', [BatchController::class, 'batchParameters'])->name('batches.parameters');
    Route::get('/batches/{param}/parameters-view/{batch}', [BatchController::class, 'paramView'])->name('batches.parameters-view');
    Route::get('/batches/{param}/print', [BatchController::class, 'paramPrint'])->name('batches.print');


});
