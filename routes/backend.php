<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    // 後台儀表板頁面
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
