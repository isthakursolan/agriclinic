<?php

use App\Http\Controllers\modules\sampleController;
use App\Http\Controllers\modules\farmerController;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Scalar\MagicConst\Dir;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('admin', function () {
//     return view('layouts.index');
// });

require __DIR__ . '/auth.php';
require __DIR__ . '/frontOffice.php';
require __DIR__ . '/farmer.php';

Route::group(['middleware' => ['role:admin|field_agent|front_office|consultant']], function () {
    Route::get('/farmer', [farmerController::class, 'farmerIndex'])->name('farmers');
    Route::get('/farmer/create', [farmerController::class, 'farmerCreate'])->name('farmer.create');
    Route::post('/farmer/store', [farmerController::class, 'farmerStore'])->name('farmer.store');
    Route::get('/farmer/edit/{id}', [farmerController::class, 'farmerEdit'])->name('farmer.edit');
    Route::post('/farmer/update/{id}', [farmerController::class, 'farmerUpdate'])->name('farmer.update');
    Route::get('/farmer/destroy/{id}', [farmerController::class, 'farmerDestroy'])->name('farmer.destroy');

    Route::get('/sample', [sampleController::class, 'index'])->name('sample');
    Route::get('/sample/create', [sampleController::class, 'create'])->name('sample.create');
    Route::post('/sample/store', [sampleController::class, 'store'])->name('sample.store');
    Route::get('/sample-type/{id}/data', [SampleController::class, 'getSampleTypeData']);
    Route::get('/samples/{sample}/edit', [SampleController::class, 'sampleEdit'])->name('sample.edit');
    Route::put('/samples/{id}', [SampleController::class, 'sampleUpdate']) ->name('sample.update');
    Route::get('/payment', [sampleController::class, 'show'])->name('payments.show');
    Route::post('/payments/confirm/{sampleId}', [sampleController::class, 'confirm'])->name('payments.confirm');
});
