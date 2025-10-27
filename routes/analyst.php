<?php

use App\Http\Controllers\analyst\analystController;
use App\Http\Controllers\analyst\analystResultController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:analyst'])->prefix('analyst')->name('analyst.')->group(function () {
    Route::get('/dashboard', [analystController::class, 'index'])->name('dashboard');

    // Results Management
    Route::resource('/results', analystResultController::class);

    // Verification
    Route::get('/verification', [analystResultController::class, 'index'])->name('verification.index');
    Route::get('/verification/{id}', [analystResultController::class, 'verify'])->name('verify');

    // Reports
    Route::get('/reports', [analystResultController::class, 'reports'])->name('report.index');
    Route::get('/report/{sample_id}', [analystResultController::class, 'showReport'])->name('report.create');
});
