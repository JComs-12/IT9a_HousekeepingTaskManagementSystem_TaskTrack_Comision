<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\AdminStaffReportController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\StaffTaskController;
use App\Http\Controllers\Staff\StaffReportController;
use App\Http\Controllers\Staff\StaffProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// ===== ADMIN ROUTES =====
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/reports', [DashboardController::class, 'reports'])
        ->name('reports.index');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])  // NEW
        ->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('rooms', RoomController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('tasks', TaskController::class);
        Route::resource('staff-reports', AdminStaffReportController::class)->only([
            'index',
            'update',
        ]);
    });

});

// ===== STAFF ROUTES =====
Route::middleware(['auth', 'staff'])->group(function () {

    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])
        ->name('staff.dashboard');

    Route::get('/staff/tasks', [StaffTaskController::class, 'index'])
        ->name('staff.tasks');

    Route::patch('/staff/tasks/{task}', [StaffTaskController::class, 'updateStatus'])
        ->name('staff.tasks.updateStatus');

    Route::get('/staff/profile', [StaffProfileController::class, 'edit'])
        ->name('staff.profile.edit');
    Route::patch('/staff/profile', [StaffProfileController::class, 'update'])
        ->name('staff.profile.update');
    Route::post('/staff/profile/avatar', [StaffProfileController::class, 'updateAvatar'])  // NEW
        ->name('staff.profile.avatar');
    Route::put('/staff/profile/password', [StaffProfileController::class, 'updatePassword'])
        ->name('staff.profile.password');

    Route::get('/staff/reports', [StaffReportController::class, 'index'])
        ->name('staff.reports.index');
    Route::get('/staff/reports/create', [StaffReportController::class, 'create'])
        ->name('staff.reports.create');
    Route::post('/staff/reports', [StaffReportController::class, 'store'])
        ->name('staff.reports.store');

});

// Auth Routes
require __DIR__.'/auth.php';