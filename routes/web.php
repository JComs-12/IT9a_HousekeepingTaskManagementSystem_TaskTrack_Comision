<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\AdminStaffReportController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\StaffTaskController;
use App\Http\Controllers\Staff\StaffReportController;
use App\Http\Controllers\Staff\StaffProfileController;
use Illuminate\Support\Facades\Route;

// Welcome Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('landing');

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
        Route::resource('staff', StaffController::class)->except(['edit', 'update']);
        Route::resource('tasks', TaskController::class);
        Route::delete('/tasks/delete-selected', [TaskController::class, 'deleteSelected'])->name('tasks.delete-selected');
        Route::resource('staff-reports', AdminStaffReportController::class)->only([
            'index',
            'update',
            'destroy',
        ]);
        Route::delete('/staff-reports/delete-selected', [AdminStaffReportController::class, 'deleteSelected'])->name('staff-reports.delete-selected');
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
        Route::delete('/logs/delete-selected', [ActivityLogController::class, 'deleteSelected'])->name('logs.delete-selected');
        Route::delete('/logs/{log}', [ActivityLogController::class, 'destroy'])->name('logs.destroy');
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

    Route::delete('/staff/tasks/{task}', [StaffTaskController::class, 'destroy'])
        ->name('staff.tasks.destroy');

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