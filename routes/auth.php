<?php

use App\Http\Controllers\accountant\accountantController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\agentFarmerController;
use App\Http\Controllers\admin\casesController;
use App\Http\Controllers\admin\CropController;
use App\Http\Controllers\admin\roleController;
use App\Http\Controllers\admin\ImpersonationController;
use App\Http\Controllers\analyst\analystController;
use App\Http\Controllers\auth\forgetPassController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\consultant\consultantController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\admin\farmerController;
use App\Http\Controllers\admin\sampleController as AdminSampleController;
use App\Http\Controllers\farmer\paymentController;
use App\Http\Controllers\farmer\sampleController;
use App\Http\Controllers\fieldAgent\fieldagentController;
use App\Http\Controllers\fieldAgent\farmerAgentController;
use App\Http\Controllers\frontoffice\frontofficeController;
use App\Http\Controllers\labscientist\scientictController;
use App\Http\Controllers\ProfileController;

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
        
        // Universal Profile Routes (for all authenticated users)
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        
        // Stop impersonation route - accessible even when impersonating (no role check, but must be authenticated)
        Route::match(['get', 'post'], '/admin/impersonate/stop', [ImpersonationController::class, 'stop'])->name('admin.impersonate.stop');
        
        // Impersonation Routes (Superadmin Only)
        Route::middleware(['auth', 'load.roles', 'role:superadmin'])->group(function () {
            Route::prefix('admin')->name('admin.')->group(function () {
                Route::get('/users', [ImpersonationController::class, 'index'])->name('users.index');
                Route::get('/users/{user}', [ImpersonationController::class, 'show'])->name('users.show');
                Route::post('/impersonate/{user}', [ImpersonationController::class, 'impersonate'])->name('impersonate.start');
            });
        });

        // Admin Routes (Admin Only - Superadmin Excluded)
        Route::middleware(['auth', 'role:admin'])->group(function () {
            Route::prefix('admin')->name('admin.')->group(function () {
                Route::get('/dashboard', [adminController::class, 'index'])->name('dashboard');

                Route::get('/crop-categories', [CropController::class, 'indexCategory'])->name('crop.categories');
                Route::get('/crop-categories/create', [CropController::class, 'createCategory'])->name('crop.categories.create');
                Route::post('/crop-categories/store', [CropController::class, 'storeCategory'])->name('crop.categories.store');
                Route::get('/crop-categories/edit/{cat_id}', [CropController::class, 'editCategory'])->name('crop.categories.edit');
                Route::post('/crop-categories/update/{cat_id}', [CropController::class, 'updateCategory'])->name('crop.categories.update');
                Route::get('/crop-categories/destroy/{cat_id}', [CropController::class, 'destroyCategory'])->name('crop.categories.destroy');

                Route::get('/crop-types', [CropController::class, 'indexType'])->name('crop.types');
                Route::get('/crop-types/create', [CropController::class, 'createType'])->name('crop.types.create');
                Route::post('/crop-types/store', [CropController::class, 'storeType'])->name('crop.types.store');
                Route::get('/crop-types/edit/{type}', [CropController::class, 'editType'])->name('crop.types.edit');
                Route::post('/crop-types/update/{type}', [CropController::class, 'updateType'])->name('crop.types.update');
                Route::get('/crop-types/destroy/{type}', [CropController::class, 'destroyType'])->name('crop.types.destroy');

                Route::get('/crops', [CropController::class, 'index'])->name('crops');
                Route::get('/crops/create', [CropController::class, 'create'])->name('crops.create');
                Route::post('/crops/store', [CropController::class, 'store'])->name('crops.store');
                Route::get('/crops/edit/{id}', [CropController::class, 'edit'])->name('crops.edit');
                Route::post('/crops/update/{id}', [CropController::class, 'update'])->name('crops.update');
                Route::get('/crops/destroy/{id}', [CropController::class, 'destroy'])->name('crops.destroy');

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

                Route::get('/crop-varieties', [CropController::class, 'indexCrops'])->name('crop-varieties');
                Route::get('/crop-varieties/create', [CropController::class, 'createCrops'])->name('crop-varieties.create');
                Route::post('/crop-varieties/store', [CropController::class, 'storeCrops'])->name('crop-varieties.store');
                Route::get('/crop-varieties/edit/{id}', [CropController::class, 'editCrops'])->name('crop-varieties.edit');
                Route::post('/crop-varieties/update/{id}', [CropController::class, 'updateCrops'])->name('crop-varieties.update');
                Route::get('/crop-varieties/destroy/{id}', [CropController::class, 'destroyCrops'])->name('crop-varieties.destroy');

                // Route::get('/farmer', [farmerController::class, 'farmerIndex'])->name('farmers');
                // Route::get('/farmer/create', [farmerController::class, 'farmerCreate'])->name('farmer.create');
                // Route::post('/farmer/store', [farmerController::class, 'farmerStore'])->name('farmer.store');
                // Route::get('/farmer/edit/{id}', [farmerController::class, 'farmerEdit'])->name('farmer.edit');
                // Route::post('/farmer/update/{id}', [farmerController::class, 'farmerUpdate'])->name('farmer.update');
                // Route::get('/farmer/destroy/{id}', [farmerController::class, 'farmerDestroy'])->name('farmer.destroy');

                Route::get('/sample-types', [casesController::class, 'typeIndex'])->name('sample-types');
                Route::get('/sample-types/create', [casesController::class, 'typeCreate'])->name('sample-types.create');
                Route::post('/sample-types/store', [casesController::class, 'typeStore'])->name('sample-types.store');
                Route::get('/sample-types/edit/{id}', [casesController::class, 'typeEdit'])->name('sample-types.edit');
                Route::post('/sample-types/update/{id}', [casesController::class, 'typeUpdate'])->name('sample-types.update');
                Route::get('/sample-types/destroy/{id}', [casesController::class, 'typeDestroy'])->name('sample-types.destroy');

                Route::get('/test-parameters', [casesController::class, 'individualIndex'])->name('test-parameters');
                Route::get('/test-parameters/create', [casesController::class, 'individualCreate'])->name('test-parameters.create');
                Route::post('/test-parameters/store', [casesController::class, 'individualStore'])->name('test-parameters.store');
                Route::get('/test-parameters/edit/{id}', [casesController::class, 'individualEdit'])->name('test-parameters.edit');
                Route::post('/test-parameters/update/{id}', [casesController::class, 'individualUpdate'])->name('test-parameters.update');
                Route::get('/test-parameters/destroy/{id}', [casesController::class, 'individualDestroy'])->name('test-parameters.destroy');

                Route::get('/test-packages', [casesController::class, 'packagesIndex'])->name('test-packages');
                Route::get('/test-packages/create', [casesController::class, 'packagesCreate'])->name('test-packages.create');
                Route::post('/test-packages/store', [casesController::class, 'packagesStore'])->name('test-packages.store');
                Route::get('/test-packages/edit/{id}', [casesController::class, 'packagesEdit'])->name('test-packages.edit');
                Route::post('/test-packages/update/{id}', [casesController::class, 'packagesUpdate'])->name('test-packages.update');
                Route::get('/test-packages/destroy/{id}', [casesController::class, 'packagesDestroy'])->name('test-packages.destroy');

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

                Route::get('/samples', [AdminSampleController::class, 'index'])->name('samples');
                Route::get('/samples/details/{id}', [AdminSampleController::class, 'details'])->name('samples.details');



        });
    });


    Route::middleware(['auth', 'role:field_agent'])->prefix('agent')->name('agent.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [fieldagentController::class, 'index'])->name('dashboard');

        // Farmers management
        Route::get('/farmers', [farmerAgentController::class, 'farmers'])->name('farmers');
        Route::get('/farmers/{id}', [farmerAgentController::class, 'showFarmer'])->name('farmers.show');

        // Fields management
        Route::get('/fields', [farmerAgentController::class, 'fields'])->name('fields');
        Route::get('/fields/{id}', [farmerAgentController::class, 'showField'])->name('fields.show');

        // Tasks management
        Route::get('/tasks', [farmerAgentController::class, 'tasks'])->name('tasks');
        Route::post('/tasks/{id}/start', [farmerAgentController::class, 'startTask'])->name('tasks.start');

        // Reports management
        Route::get('/reports', [farmerAgentController::class, 'reports'])->name('reports');
        Route::get('/reports/create/{task}', [farmerAgentController::class, 'createReport'])->name('reports.create');
        Route::post('/reports/{task}', [farmerAgentController::class, 'storeReport'])->name('reports.store');
        Route::get('/reports/{id}', [farmerAgentController::class, 'showReport'])->name('reports.show');
        Route::get('/reports/{id}/edit', [farmerAgentController::class, 'editReport'])->name('reports.edit');
        Route::put('/reports/{id}', [farmerAgentController::class, 'updateReport'])->name('reports.update');
        Route::delete('/reports/{report}/attachments/{index}', [farmerAgentController::class, 'deleteAttachment'])->name('reports.delete-attachment');
        // Sample collection
        Route::get('/samples', [farmerAgentController::class, 'samplesShow'])->name('samples');
        Route::post('/samples/collect/{id}', [farmerAgentController::class, 'collectSample'])->name('samples.collect');
        Route::post('/accept-sample/{id}', [farmerAgentController::class, 'acceptSample'])->name('sample.accept');
    });


    Route::middleware(['auth', 'role:accountant'])->prefix('acc')->name('acc.')->group(function () {
        Route::get('/dashboard', [accountantController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['auth', 'role:consultant'])->prefix('con')->name('con.')->group(function () {
        Route::get('/dashboard', [consultantController::class, 'index'])->name('dashboard');
    });
});
