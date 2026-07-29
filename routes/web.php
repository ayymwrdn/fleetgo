<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ApproverDashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\VehicleMonitoringController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ============================================================
// PUBLIC ROUTES
// ============================================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================================
// AUTH ROUTES (dari Breeze)
// ============================================================
require __DIR__.'/auth.php';

// ============================================================
// REDIRECT /dashboard
// ============================================================
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect('/admin/dashboard');
    }
    if (auth()->check() && auth()->user()->isApprover()) {
        return redirect('/approver/dashboard');
    }
    return redirect('/login');
})->middleware('auth')->name('dashboard');

// ============================================================
// AUTHENTICATED ROUTES (harus login)
// ============================================================
Route::middleware(['auth'])->group(function () {
    
    // ============================================================
    // ADMIN ROUTES (hanya admin)
    // ============================================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Booking Management
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        
        // Reports & Export
        Route::get('/reports/export', [BookingController::class, 'export'])->name('bookings.export');
        
        // Activity Logs
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs');
        
        // ===== VEHICLE MONITORING (CRUD) =====
        Route::get('/vehicles', [VehicleMonitoringController::class, 'index'])->name('vehicles.index');
        Route::get('/vehicles/create', [VehicleMonitoringController::class, 'create'])->name('vehicles.create');
        Route::post('/vehicles', [VehicleMonitoringController::class, 'store'])->name('vehicles.store');
        Route::get('/vehicles/{id}', [VehicleMonitoringController::class, 'show'])->name('vehicles.show');
        Route::get('/vehicles/{id}/edit', [VehicleMonitoringController::class, 'edit'])->name('vehicles.edit');
        Route::put('/vehicles/{id}', [VehicleMonitoringController::class, 'update'])->name('vehicles.update');
        Route::delete('/vehicles/{id}', [VehicleMonitoringController::class, 'destroy'])->name('vehicles.destroy');
    });
    
    // ============================================================
    // APPROVER ROUTES (hanya approver)
    // ============================================================
    Route::middleware(['role:approver'])->prefix('approver')->name('approver.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [ApproverDashboardController::class, 'index'])->name('dashboard');
        
        // Approval Actions
        Route::post('/approve/{booking}', [ApproverDashboardController::class, 'approve'])->name('approve');
        Route::post('/reject/{booking}', [ApproverDashboardController::class, 'reject'])->name('reject');
    });
});