<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;

Route::prefix('admin')->middleware(['auth', 'role.weight:1', 'verified'])->group(function () {
    // 後台儀表板頁面
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/studentManage', [DashboardController::class, 'studentManage'])->name('studentManage');
    Route::put('/studentUpdate', [DashboardController::class, 'studentUpdate'])->name('studentUpdate');

    Route::get('/presenterManage', [DashboardController::class, 'presenterManage'])->name('presenterManage');
    Route::put('/presenterUpdate', [DashboardController::class, 'presenterUpdate'])->name('presenterUpdate');

    Route::get('/activityManage', [DashboardController::class, 'activityManage'])->name('activityManage');
    Route::put('/activityUpdate', [DashboardController::class, 'activityUpdate'])->name('activityUpdate');
});
