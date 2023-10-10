<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;

Route::prefix('admin')->middleware(['auth', 'role.weight:1', 'verified'])->group(function () {
    // 後台儀表板頁面
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/studentManage', [DashboardController::class, 'studentManage'])->name('studentManage');
    Route::get('/presenterManage', [DashboardController::class, 'presenterManage'])->name('presenterManage');
    Route::get('/activityManage', [DashboardController::class, 'activityManage'])->name('activityManage');
});
