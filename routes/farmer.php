<?php

use App\Http\Controllers\farmer\farmerController;
use App\Http\Controllers\farmer\paymentController;
use App\Http\Controllers\farmer\sampleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:farmer'])->prefix('/user')->name('user.')->group(function () {
    // Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [farmerController::class, 'index'])->name('dashboard');

    Route::get('/profile', [farmerController::class, 'profileForm'])->name('profile');
    Route::get('/profile/edit', [farmerController::class, 'profileEdit'])->name('profile.edit');
    Route::post('/profile/store/{id}', [farmerController::class, 'profileStore'])->name('profile.store');

    Route::get('/crop', [farmerController::class, 'crop'])->name('crop');
    Route::get('/addCrop', [farmerController::class, 'cropForm'])->name('add.crop');
    Route::post('/crop/store', [farmerController::class, 'cropStore'])->name('crop.store');
    Route::get('/get-varieties/{cropId}', [farmerController::class, 'getVarieties']);
    Route::get('/get-rootstocks/{cropId}', [farmerController::class, 'getRootstocks']);
    Route::get('/get-croptype/{cropType}', [farmerController::class, 'getCropType']);
    Route::get('/get-cropcat/{cropCat}', [farmerController::class, 'getCropCat']);
    Route::get('/edit/crop/{crop_id}', [farmerController::class, 'cropEdit'])->name('edit.crop');
    Route::post('/crop/update/{crop_id}', [farmerController::class, 'cropUpdate'])->name('update.crop');
    Route::get('/crop/destroy/{crop_id}', [farmerController::class, 'cropDestroy'])->name('crop.destroy');

    // Route::get('/active-crop', [farmerController::class, 'cropForm'])->name('active-crop');

    Route::get('/field', [farmerController::class, 'field'])->name('field');
    Route::post('/field/store', [farmerController::class, 'fieldStore'])->name('field.store');
    Route::get('/addField', [farmerController::class, 'fieldForm'])->name('add.field');
    Route::get('/edit/Field/{field_id}', [farmerController::class, 'fieldEdit'])->name('edit.field');
    Route::post('/field/update/{field_id}', [farmerController::class, 'fieldUpdate'])->name('update.field');
    Route::get('/field/destroy/{field_id}', [farmerController::class, 'fieldDestroy'])->name('field.destroy');

    Route::get('/sample', [sampleController::class, 'index'])->name('sample');
    Route::get('/sample/create', [sampleController::class, 'create'])->name('sample.create');
    Route::post('/sample/store', [sampleController::class, 'store'])->name('sample.store');
    Route::get('/sample-type/{id}/data', [SampleController::class, 'getSampleTypeData']);
    Route::get('/samples/{sample}/edit', [SampleController::class, 'edit']);

    Route::get('/payment', [paymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/confirm/{sampleId}', [paymentController::class, 'confirm'])->name('payments.confirm');
});
