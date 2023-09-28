<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\PresenterController;

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/activityDetails', [IndexController::class, 'activityDetails'])->name('activityDetails');

Route::get('/createActivity', [PresenterController::class, 'createActivity'])->name('createActivity');
Route::post('/activityStore', [PresenterController::class, 'activityStore'])->name('activityStore');


Route::get('/activityClassification', [IndexController::class, 'activityClassification'])->name('activityClassification');
