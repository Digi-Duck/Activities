<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/activity_details', [IndexController::class, 'activity_details'])->name('activity_details');

Route::get('/create_activity', [IndexController::class, 'create_activity'])->name('create_activity');

Route::get('/activity_classification', [IndexController::class, 'activity_classification'])->name('activity_classification');