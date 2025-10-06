<?php

use App\Http\Controllers\labscientist\batchController;
use App\Http\Controllers\labscientist\scientictController;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:lab_scientist'])->prefix('lab')->name('lab.')->group(function () {
    Route::get('/dashboard', [scientictController::class, 'index'])->name('dashboard');

    Route::get('/batches', [batchController::class, 'index'])->name('batches.index');
    Route::get('/batches/{id}', [batchController::class, 'show'])->name('batches.show');
    Route::get('/batches/{id}/parameters', [batchController::class, 'parameters'])->name('batches.parameters');
    Route::get('/batches/{param}/parameters-view/{batch}', [batchController::class, 'paramView'])->name('batches.parameter');
    Route::get('/batches/{param}/result-edit/{sample}', [batchController::class, 'paramEdit'])->name('batches.parameter-edit');
    Route::post('/batches/result-update/{id}', [batchController::class, 'paramUpdate'])->name('parameters.update');
    Route::get('/batches/{param}/result-show/{sample}', [batchController::class, 'resultView'])->name('batches.result-view');

    Route::get('/investigations', [batchController::class, 'investigations'])->name('investigations.index');

});
