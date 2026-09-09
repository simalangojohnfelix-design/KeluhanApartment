<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\PropertyUnitController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Tenant\ComplaintController as TenantComplaintController;
use App\Http\Controllers\Tenant\UnitAssetController;
use App\Http\Controllers\Technician\WorkOrderController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\ApprovalController;
use App\Http\Controllers\Owner\CostLogController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('assets', AssetController::class);
    Route::resource('units', PropertyUnitController::class);
    Route::resource('complaints', AdminComplaintController::class);
    Route::resource('users', UserController::class);
});

// Tenant Routes
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->name('tenant.')->group(function() {
    Route::get('/dashboard', function() { return view('tenant.dashboard'); })->name('dashboard');
    Route::resource('complaints', TenantComplaintController::class);
    Route::post('complaints/{id}/rate', [TenantComplaintController::class, 'rate'])->name('complaints.rate');
    Route::get('assets', [UnitAssetController::class, 'index'])->name('assets.index');
});

// Technician Routes
Route::middleware(['auth', 'role:technician'])->prefix('technician')->name('technician.')->group(function() {
    Route::get('/tasks', [WorkOrderController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{id}', [WorkOrderController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{id}', [WorkOrderController::class, 'update'])->name('tasks.update');
});

// Owner Routes
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function() {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::put('/approvals/{id}', [ApprovalController::class, 'update'])->name('approvals.update');
    Route::get('/cost-log', [CostLogController::class, 'index'])->name('cost-log.index');
});
