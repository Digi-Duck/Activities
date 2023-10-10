<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\PresenterController;
use App\Http\Controllers\Frontend\StudentController;

Route::get('/', [IndexController::class, 'index'])->name('index');

// Route::get('/globalActivityDetails/{id}', [IndexController::class, 'globalActivityDetails'])->name('globalActivityDetails');

Route::middleware(['auth', 'role.weight:2', 'verified'])->prefix('/presenter')->group(function () {
    Route::get('/personalPage', [PresenterController::class, 'index'])->name('presenterPersonalPage');
    Route::get('/createActivity', [PresenterController::class, 'createActivity'])->name('createActivity');
    Route::post('/activityStore', [PresenterController::class, 'activityStore'])->name('activityStore');
    Route::get('/activityEdit{id}', [PresenterController::class, 'activityEdit'])->name('activityEdit');
    Route::get('/activityScanner{id}', [PresenterController::class, 'activityScanner'])->name('activityScanner');
    Route::put('/activityUpdate', [PresenterController::class, 'activityUpdate'])->name('activityUpdate');
    Route::delete('/activityDelete', [PresenterController::class, 'activityDelete'])->name('activityDelete');
});

Route::get('/activityClassification', [IndexController::class, 'activityClassification'])->name('activityClassification');
Route::middleware(['auth', 'role.weight:3', 'verified'])->prefix('/student')->group(function () {
    Route::get('/studentActivityDetails/{id}', [StudentController::class, 'index'])->name('studentActivityDetails');
    Route::get('/personalPage', [StudentController::class, 'personalPage'])->name('studentPersonalPage');
    Route::get('/activityEdit{id}', [StudentController::class, 'activityEdit'])->name('studentActivityEdit');
    Route::put('/registerUpdate', [StudentController::class, 'registerUpdate'])->name('registerUpdate');
    Route::delete('/registerDelete', [StudentController::class, 'registerDelete'])->name('registerDelete');
    Route::post('/registerStore', [StudentController::class, 'create'])->name('registerStore');
    Route::post('/createFavorite', [StudentController::class, 'createFavorite'])->name('createFavorite');
    Route::delete('/cancelFavorite', [StudentController::class, 'cancelFavorite'])->name('cancelFavorite');
});
