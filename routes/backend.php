<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;

Route::prefix('admin')->middleware(['auth', 'role.weight:1', 'verified'])->group(function () {
    // 後台儀表板頁面
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/studentMange', [DashboardController::class, 'studentMange'])->name('studentMange');
    Route::get('/presenterMange', [DashboardController::class, 'presenterMange'])->name('presenterMange');
    Route::get('/activityMange', [DashboardController::class, 'activityMange'])->name('activityMange');
});
