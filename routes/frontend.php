<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\PresenterController;
use App\Http\Controllers\StudentController;

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/activityDetails', [IndexController::class, 'activityDetails'])->name('activityDetails');

Route::get('/presenterPersonalPage', [PresenterController::class, 'index'])->name('presenterPersonalPage');
Route::get('/createActivity', [PresenterController::class, 'createActivity'])->name('createActivity');
Route::post('/activityStore', [PresenterController::class, 'activityStore'])->name('activityStore');
Route::get('/activityEdit/{id}', [PresenterController::class, 'activityEdit'])->name('activityEdit');

Route::get('/studentActivityDetails', [StudentController::class, 'studentActivityDetails'])->name('studentActivityDetails');

Route::get('/activityClassification', [IndexController::class, 'activityClassification'])->name('activityClassification');
