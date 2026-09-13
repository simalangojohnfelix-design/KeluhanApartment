<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyUnit;
use App\Models\Asset;
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
Route::post('/login/tenant', [AuthController::class, 'loginTenant'])->name('login.tenant');
Route::post('/login/staff', [AuthController::class, 'loginStaff'])->name('login.staff');
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
    // Rute dashboard dimodifikasi untuk menarik data unit dan aset penyewa yang sedang login
    Route::get('/dashboard', function() { 
        $unit = PropertyUnit::where('user_id', Auth::id())->first();
        // Jika unit ditemukan, ambil asetnya. Jika tidak, kirim koleksi kosong.
        $assets = $unit ? Asset::where('property_unit_id', $unit->id)->get() : collect();
        
        return view('tenant.dashboard', compact('assets')); 
    })->name('dashboard');
    
    Route::resource('complaints', TenantComplaintController::class);
    Route::post('complaints/{id}/rate', [TenantComplaintController::class, 'rate'])->name('complaints.rate');
    Route::get('assets', [UnitAssetController::class, 'index'])->name('assets.index');
});

// Technician Routes
Route::middleware(['auth', 'role:technician'])->prefix('technician')->name('technician.')->group(function() {
    Route::get('/tasks', [WorkOrderController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{id}', [WorkOrderController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{id}/invoice', [WorkOrderController::class, 'invoice'])->name('tasks.invoice');
    Route::put('/tasks/{id}', [WorkOrderController::class, 'update'])->name('tasks.update');
});

Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function() {
    // Memanggil alias yang sudah Anda daftarkan di bagian 'use' paling atas
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::put('/approvals/{id}', [ApprovalController::class, 'update'])->name('approvals.update');
    Route::get('/cost-log', [CostLogController::class, 'index'])->name('cost-log.index');

    // Route CRUD Mutlak Owner (Tetap pakai full path agar tidak bentrok dengan controller Admin di atas)
    Route::resource('users', \App\Http\Controllers\Owner\UserController::class);
    Route::resource('units', \App\Http\Controllers\Owner\UnitController::class);
    Route::resource('assets', \App\Http\Controllers\Owner\AssetController::class);
});