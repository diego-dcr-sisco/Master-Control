<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\DashboardController;
use App\HTTP\Controllers\UserController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

Route::prefix('subscriptions')
    ->name('subscriptions.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [TenantController::class, 'index'])->name('index');
        Route::get('/create', [TenantController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [TenantController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [TenantController::class, 'update'])->name('update');
        Route::post('/store', [TenantController::class, 'store'])->name('store');
        //Route::post('/{id}/toggle-status', [TenantController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/edit/{id}',[TenantController::class,'editView'])->name('edit.view');
        Route::get('/delete/{id}', [TenantController::class, 'destroy'])->name('destroy');
        Route::get('/admin/create/{id}',[TenantController::class, 'adminsCreate'])->name('adminsCreate');
        Route::get('/{id}/branches', [TenantController::class, 'branches'])->name('branches');
        Route::get('/{id}/admin', [TenantController::class, 'admins'])->name('admins');
        Route::get('/{id}/admin/{admin}/edit', [TenantController::class, 'editAdmin'])->name('admin.edit');
        Route::put('/{id}/admin/{admin}/update', [TenantController::class, 'updateAdmin'])->name('admin.update');
        Route::post('/{id}/admin/store', [TenantController::class, 'adminStore'])->name('adminStore');
        Route::get('/{id}/branches/{branch}/edit', [TenantController::class, 'editBranch'])->name('branch.edit');
        Route::put('/{id}/branches/{branch}/update', [TenantController::class, 'updateBranch'])->name('branch.update');
        
        //Rutas usuarios 
        Route::get('/{id}/users',[UserController::class,'index'])->name('users.index');
        Route::get('/{id}/users/{userId}',[UserController::class,'edit'])->name('users.edit');
        Route::put('/{id}/users/{userId}/update',[UserController::class,'update'])->name('users.update');
        Route::put('/{id}/users/{userId}/update-client',[UserController::class,'updateClient'])->name('users.update.client');
        Route::get('/{id}/branches/{branch}/users/create',[UserController::class,'create'])->name('branch.user.create');
        Route::post('/{id}/branches/{branch}/users/store',[UserController::class,'store'])->name('branch.user.store');
    
        // Rutas permisos de tenants
        Route::get('/{id}/permissions',[TenantController::class,'permissions'])->name('permissions');
        Route::put('/{id}/permission/update',[TenantController::class,'updatePermission'])->name('permission.update');
    });

Route::prefix('plans')
    ->name('plans.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('index');
        Route::get('/create', [PlanController::class, 'create'])->name('create');
        Route::post('/store', [PlanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PlanController::class, 'edit'])->name('edit');
        Route::delete('/destroy/{id}', [PlanController::class, 'destroy'])->name('destroy');
        Route::put('/update/{id}', [PlanController::class, 'update'])->name('update');
    });




require __DIR__.'/auth.php';
