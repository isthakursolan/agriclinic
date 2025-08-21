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
Route::get('/logout', [loginController::class, 'logout'])->name('logout');
Route::middleware(['guest'])->group(function () {
    // Route::get('/', function () {
    //     return view('auth.login');
    // });
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login/login', [loginController::class, 'login'])->name('login.login');
    Route::get('/register', [registerController::class, 'index'])->name('register');
    Route::post('/register/store', [registerController::class, 'register'])->name('register.store');
});

Route::middleware(['auth:farmer'])->prefix('/user')->name('user.')->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');
    // Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [farmerController::class, 'index'])->name('dashboard');

    Route::get('/profile', [farmerController::class, 'profileForm'])->name('profile');
    Route::post('/profile/store/{id}', [farmerController::class, 'profileStore'])->name('profile.store');

    Route::get('/crop', [farmerController::class, 'crop'])->name('crop');
    Route::get('/addCrop', [farmerController::class, 'cropForm'])->name('add.crop');
    Route::post('/crop/store', [farmerController::class, 'cropStore'])->name('crop.store');
    Route::get('/get-varieties/{cropId}', [farmerController::class, 'getVarieties']);
    Route::get('/get-rootstocks/{cropId}', [farmerController::class, 'getRootstocks']);
    Route::get('/get-croptype/{cropType}', [farmerController::class, 'getCropType']);
    Route::get('/get-cropcat/{cropCat}', [farmerController::class, 'getCropCat']);

    // Route::get('/active-crop', [farmerController::class, 'cropForm'])->name('active-crop');

    Route::get('/field', [farmerController::class, 'field'])->name('field');
    Route::post('/field/store', [farmerController::class, 'fieldStore'])->name('field.store');
    Route::get('/addField', [farmerController::class, 'fieldForm'])->name('add.field');
});
Route::middleware(['auth:admin, superadmin'])->prefix('/admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [adminController::class, 'index'])->name('dashboard');
});
