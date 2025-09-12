<?php

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
    Route::get('/payments/paid', [FrontOfficePaymentController::class, 'paid'])->name('payments.paid');
});
