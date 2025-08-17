<?php

use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\farmerController;

// Route::get('form', function () {
//     return view('farmer.profile');
// });
Route::middleware(['guest'])->group(function () {
    // Route::get('/', function () {
    //     return view('auth.login');
    // });
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login/login', [loginController::class, 'login'])->name('login.login');
    Route::get('/register', [registerController::class, 'index'])->name('register');
    Route::post('/register/store', [registerController::class, 'register'])->name('register.store');
});

Route::middleware(['auth:farmer'])->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');
    // Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/dashboard', [farmerController::class, 'index'])->name('user.dashboard');

    Route::get('/profile', [farmerController::class, 'profileForm'])->name('profile');
    Route::post('/profile/store/{id}', [farmerController::class, 'profileStore'])->name('profile.store');
    Route::get('/crop', [farmerController::class, 'cropForm'])->name('crop');
    Route::post('/crop/store', [farmerController::class, 'cropStore'])->name('crop.store');
    Route::get('/field', [farmerController::class, 'fieldForm'])->name('field');
    Route::post('/field/store', [farmerController::class, 'fieldStore'])->name('field.store');

    Route::get('/active-crop', [farmerController::class, 'cropForm'])->name('active-crop');
    Route::get('/fields', [farmerController::class, 'fieldFrom'])->name('fields');
});
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');

    Route::get('/admin/dashboard', [adminController::class, 'index'])->name('admin.dashboard');
});
