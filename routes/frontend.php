<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/activityDetails', [IndexController::class, 'activityDetails'])->name('activityDetails');

Route::get('/createActivity', [IndexController::class, 'createActivity'])->name('createActivity');

Route::get('/activityClassification', [IndexController::class, 'activityClassification'])->name('activityClassification');
