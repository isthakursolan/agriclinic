<?php

use App\Http\Controllers\admin\adminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\farmer\farmerController;

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

    Route::get('/crop', [farmerController::class, 'crop'])->name('crop');
    Route::get('/addCrop', [farmerController::class, 'cropForm'])->name('add.crop');
    Route::post('/crop/store', [farmerController::class, 'cropStore'])->name('crop.store');
    // Route::get('/active-crop', [farmerController::class, 'cropForm'])->name('active-crop');

    Route::get('/field', [farmerController::class, 'field'])->name('field');
    Route::post('/field/store', [farmerController::class, 'fieldStore'])->name('field.store');
    Route::get('/addField', [farmerController::class, 'fieldFrom'])->name('add.field');
});
Route::middleware(['auth:admin, superadmin'])->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');

    Route::get('/admin/dashboard', [adminController::class, 'index'])->name('admin.dashboard');
});
