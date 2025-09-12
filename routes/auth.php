<?php

use App\Http\Controllers\accountant\accountantController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\agentFarmerController;
use App\Http\Controllers\admin\casesController;
use App\Http\Controllers\admin\CropController;
use App\Http\Controllers\admin\farmerController as AdminFarmerController;
use App\Http\Controllers\admin\roleController;
use App\Http\Controllers\analyst\analystController;
use App\Http\Controllers\auth\forgetPassController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\consultant\consultantController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\farmer\farmerController;
use App\Http\Controllers\farmer\paymentController;
use App\Http\Controllers\farmer\sampleController;
use App\Http\Controllers\fieldAgent\fieldagentController;
use App\Http\Controllers\fieldAgent\farmerAgentController;
use App\Http\Controllers\frontoffice\frontofficeController;
use App\Http\Controllers\labscientist\scientictController;

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
    // Show forgot password form
    Route::get('/forgot-password', [forgetPassController::class, 'showLinkRequestForm'])->name('password.request');
    // Send reset link
    Route::post('/forgot-password', [forgetPassController::class, 'sendResetLink'])->name('password.email');
    // Show reset password form
    Route::get('/reset-password', [forgetPassController::class, 'showResetForm'])->name('password.reset');
    // Submit new password
    Route::post('/reset-password', [forgetPassController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');
    // Admin Field Agent Management Routes
    Route::middleware(['auth', 'role:admin|superadmin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [adminController::class, 'index'])->name('dashboard');

            Route::get('/crop-cat', [CropController::class, 'indexCategory'])->name('crop.cat');
            Route::get('/crop-cat/create', [CropController::class, 'createCategory'])->name('crop.cat.create');
            Route::post('/crop-cat/store', [CropController::class, 'storeCategory'])->name('crop.cat.store');
            Route::get('/crop-cat/edit/{cat_id}', [CropController::class, 'editCategory'])->name('crop.cat.edit');
            Route::post('/crop-cat/update/{cat_id}', [CropController::class, 'updateCategory'])->name('crop.cat.update');
            Route::get('/crop-cat/destroy/{cat_id}', [CropController::class, 'destroyCategory'])->name('crop.cat.destroy');

            Route::get('/crop-type', [CropController::class, 'indexType'])->name('crop.type');
            Route::get('/crop-type/create', [CropController::class, 'createType'])->name('crop.type.create');
            Route::post('/crop-type/store', [CropController::class, 'storeType'])->name('crop.type.store');
            Route::get('/crop-type/edit/{type}', [CropController::class, 'editType'])->name('crop.type.edit');
            Route::post('/crop-type/update/{type}', [CropController::class, 'updateType'])->name('crop.type.update');
            Route::get('/crop-type/destroy/{type}', [CropController::class, 'destroyType'])->name('crop.type.destroy');

            Route::get('/crop', [CropController::class, 'index'])->name('crop');
            Route::get('/crop/create', [CropController::class, 'create'])->name('crop.create');
            Route::post('/crop/store', [CropController::class, 'store'])->name('crop.store');
            Route::get('/crop/edit/{id}', [CropController::class, 'edit'])->name('crop.edit');
            Route::post('/crop/update/{id}', [CropController::class, 'update'])->name('crop.update');
            Route::get('/crop/destroy/{id}', [CropController::class, 'destroy'])->name('crop.destroy');

            Route::get('/variety', [CropController::class, 'indexVariety'])->name('variety');
            Route::get('/variety/create', [CropController::class, 'createVariety'])->name('variety.create');
            Route::post('/variety/store', [CropController::class, 'storeVariety'])->name('variety.store');
            Route::get('/variety/edit/{id}', [CropController::class, 'editVariety'])->name('variety.edit');
            Route::post('/variety/update/{id}', [CropController::class, 'updateVariety'])->name('variety.update');
            Route::get('/variety/destroy/{id}', [CropController::class, 'destroyVariety'])->name('variety.destroy');
            Route::delete('variety/delete-one/{id}', [CropController::class, 'destroySingle'])->name('variety.destroySingle');

            Route::get('/rootstock', [CropController::class, 'indexRootstock'])->name('rootstock');
            Route::get('/rootstock/create', [CropController::class, 'createRootstock'])->name('rootstock.create');
            Route::post('/rootstock/store', [CropController::class, 'storeRootstock'])->name('rootstock.store');
            Route::get('/rootstock/edit/{id}', [CropController::class, 'editRootstock'])->name('rootstock.edit');
            Route::post('/rootstock/update/{id}', [CropController::class, 'updateRootstock'])->name('rootstock.update');
            Route::get('/rootstock/destroy/{id}', [CropController::class, 'destroyRootstock'])->name('rootstock.destroy');
            Route::delete('rootstock/delete-one/{id}', [CropController::class, 'destroySingleRoot'])->name('rootstock.destroySingle');

            Route::get('/crops', [CropController::class, 'indexCrops'])->name('crops');
            Route::get('/crops/create', [CropController::class, 'createCrops'])->name('crops.create');
            Route::post('/crops/store', [CropController::class, 'storeCrops'])->name('crops.store');
            Route::get('/crops/edit/{id}', [CropController::class, 'editCrops'])->name('crops.edit');
            Route::post('/crops/update/{id}', [CropController::class, 'updateCrops'])->name('crops.update');
            Route::get('/crops/destroy/{id}', [CropController::class, 'destroyCrops'])->name('crops.destroy');

            Route::get('/farmer', [AdminFarmerController::class, 'farmerIndex'])->name('farmers');
            Route::get('/farmer/create', [AdminFarmerController::class, 'farmerCreate'])->name('farmer.create');
            Route::post('/farmer/store', [AdminFarmerController::class, 'farmerStore'])->name('farmer.store');
            Route::get('/farmer/edit/{id}', [AdminFarmerController::class, 'farmerEdit'])->name('farmer.edit');
            Route::post('/farmer/update/{id}', [AdminFarmerController::class, 'farmerUpdate'])->name('farmer.update');
            Route::get('/farmer/destroy/{id}', [AdminFarmerController::class, 'farmerDestroy'])->name('farmer.destroy');

            Route::get('/sampleType', [casesController::class, 'typeIndex'])->name('sampleType');
            Route::get('/sampleType/create', [casesController::class, 'typeCreate'])->name('sampleType.create');
            Route::post('/sampleType/store', [casesController::class, 'typeStore'])->name('sampleType.store');
            Route::get('/sampleType/edit/{id}', [casesController::class, 'typeEdit'])->name('sampleType.edit');
            Route::post('/sampleType/update/{id}', [casesController::class, 'typeUpdate'])->name('sampleType.update');
            Route::get('/sampleType/destroy/{id}', [casesController::class, 'typeDestroy'])->name('sampleType.destroy');

            Route::get('/singlePara', [casesController::class, 'individualIndex'])->name('singlePara');
            Route::get('/singlePara/create', [casesController::class, 'individualCreate'])->name('singlePara.create');
            Route::post('/singlePara/store', [casesController::class, 'individualStore'])->name('singlePara.store');
            Route::get('/singlePara/edit/{id}', [casesController::class, 'individualEdit'])->name('singlePara.edit');
            Route::post('/singlePara/update/{id}', [casesController::class, 'individualUpdate'])->name('singlePara.update');
            Route::get('/singlePara/destroy/{id}', [casesController::class, 'individualDestroy'])->name('singlePara.destroy');

            Route::get('/packages', [casesController::class, 'packagesIndex'])->name('packages');
            Route::get('/packages/create', [casesController::class, 'packagesCreate'])->name('packages.create');
            Route::post('/packages/store', [casesController::class, 'packagesStore'])->name('packages.store');
            Route::get('/packages/edit/{id}', [casesController::class, 'packagesEdit'])->name('packages.edit');
            Route::post('/packages/update/{id}', [casesController::class, 'packagesUpdate'])->name('packages.update');
            Route::get('/packages/destroy/{id}', [casesController::class, 'packagesDestroy'])->name('packages.destroy');

            Route::get('/roles', [roleController::class, 'index'])->name('roles');
            Route::get('/roles/{user}/edit', [roleController::class, 'edit'])->name('roles.edit');
            Route::post('/roles/{user}', [roleController::class, 'update'])->name('roles.update');

            Route::get('field-agents', [agentFarmerController::class, 'index'])->name('field-agents');
            Route::get('field-agents/assign', [agentFarmerController::class, 'assignForm'])->name('field-agents.assign-form');
            Route::post('field-agents/assign', [agentFarmerController::class, 'assignFarmer'])->name('field-agents.assign-farmer');
            Route::get('field-agents/create-task', [agentFarmerController::class, 'createTask'])->name('field-agents.create-task');
            Route::post('field-agents/store-task', [agentFarmerController::class, 'storeTask'])->name('field-agents.store-task');
            Route::get('field-agents/edit-task/{task}', [agentFarmerController::class, 'editTask'])->name('field-agents.edit-task');
            Route::put('field-agents/update-task/{task}', [agentFarmerController::class, 'updateTask'])->name('field-agents.update-task');
            Route::delete('field-agents/destroy-task/{task}', [agentFarmerController::class, 'destroyTask'])->name('field-agents.destroy-task');
            Route::get('field-agents/assigned-farmers', [agentFarmerController::class, 'assignedFarmers'])->name('field-agents.assigned-farmers');
            Route::delete('field-agents/unassign/{farmer}/{agent}', [agentFarmerController::class, 'unassign'])->name('field-agents.unassign');
            Route::get('field-agents/tasks/{agent}', [agentFarmerController::class, 'tasksByAgent'])->name('field-agents.tasks');
            Route::get('field-agents/get-fields/{farmer}', [agentFarmerController::class, 'getFieldsByFarmer']);

            // NEW: Admin Report Management Routes
            Route::get('field-agents/reports', [agentFarmerController::class, 'allReports'])->name('field-agents.reports');
            Route::get('field-agents/reports/{report}', [agentFarmerController::class, 'showReport'])->name('field-agents.reports.show');
            Route::post('field-agents/reports/{report}/approve', [agentFarmerController::class, 'approveReport'])->name('field-agents.reports.approve');
            Route::post('field-agents/reports/{report}/reject', [agentFarmerController::class, 'rejectReport'])->name('field-agents.reports.reject');
            Route::get('field-agents/reports/by-agent/{agent}', [agentFarmerController::class, 'reportsByAgent'])->name('field-agents.reports.by-agent');
        });
    });

    Route::middleware(['auth', 'role:field_agent'])->prefix('agent')->name('agent.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [fieldagentController::class, 'index'])->name('dashboard');

        // Farmers management
        Route::get('/farmers', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'farmers'])->name('farmers');
        Route::get('/farmers/{id}', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'showFarmer'])->name('farmers.show');

        // Fields management
        Route::get('/fields', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'fields'])->name('fields');
        Route::get('/fields/{id}', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'showField'])->name('fields.show');

        // Tasks management
        Route::get('/tasks', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'tasks'])->name('tasks');
        Route::post('/tasks/{id}/start', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'startTask'])->name('tasks.start');

        // Reports management
        Route::get('/reports', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'reports'])->name('reports');
        Route::get('/reports/create/{task}', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'createReport'])->name('reports.create');
        Route::post('/reports/{task}', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'storeReport'])->name('reports.store');
        Route::get('/reports/{id}', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'showReport'])->name('reports.show');
        Route::get('/reports/{id}/edit', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'editReport'])->name('reports.edit');
        Route::put('/reports/{id}', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'updateReport'])->name('reports.update');
        Route::delete('/reports/{report}/attachments/{index}', [App\Http\Controllers\fieldAgent\farmerAgentController::class, 'deleteAttachment'])->name('reports.delete-attachment');
    });


    Route::middleware(['auth', 'role:accountant'])->prefix('acc')->name('acc.')->group(function () {
        Route::get('/dashboard', [accountantController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['auth', 'role:lab_scientist'])->prefix('lab')->name('lab.')->group(function () {
        Route::get('/dashboard', [scientictController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['auth', 'role:analyst'])->prefix('analyst')->name('analyst.')->group(function () {
        Route::get('/dashboard', [analystController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['auth', 'role:consultant'])->prefix('con')->name('con.')->group(function () {
        Route::get('/dashboard', [consultantController::class, 'index'])->name('dashboard');
    });
});
