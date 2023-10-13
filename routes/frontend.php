<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\PresenterController;
use App\Http\Controllers\Frontend\StudentController;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/activityClassification', [IndexController::class, 'activityClassification'])->name('activityClassification');
Route::get('/declaration', [IndexController::class, 'declaration'])->name('declaration');

Route::middleware(['auth'])->group(function () {
    Route::get('/userInfo', [IndexController::class, 'userInfo'])->name('userInfo');
    Route::get('/changeUserInfo{id}', [IndexController::class, 'changeUserInfo'])->name('changeUserInfo');
    Route::put('/userInfoUpdate', [IndexController::class, 'userInfoUpdate'])->name('userInfoUpdate');
});

Route::middleware(['auth', 'role.weight:2', 'verified'])->prefix('/presenter')->group(function () {
    Route::get('/presenterPersonalPage', [PresenterController::class, 'presenterPersonalPage'])->name('presenterPersonalPage');
    Route::get('/createActivity', [PresenterController::class, 'createActivity'])->name('createActivity');
    Route::post('/activityStore', [PresenterController::class, 'activityStore'])->name('activityStore');
    Route::get('/activityEdit{id}', [PresenterController::class, 'activityEdit'])->name('activityEdit');
    Route::put('/activityPresenterUpdate', [PresenterController::class, 'activityPresenterUpdate'])->name('activityPresenterUpdate');
    Route::delete('/activityDelete', [PresenterController::class, 'activityDelete'])->name('activityDelete');
    Route::get('/activityScanner{id}', [PresenterController::class, 'activityScanner'])->name('activityScanner');
    Route::post('/activityScannerConfirm', [PresenterController::class, 'activityScannerConfirm'])->name('activityScannerConfirm');
    Route::get('/presenterFinishedActivity{id}', [PresenterController::class, 'presenterFinishedActivity'])->name('presenterFinishedActivity');
});

Route::get('/studentActivityDetails/{id}', [StudentController::class, 'index'])->name('studentActivityDetails');
Route::middleware(['auth', 'role.weight:3', 'verified'])->prefix('/student')->group(function () {
    Route::get('/personalPage', [StudentController::class, 'personalPage'])->name('studentPersonalPage');
    Route::get('/activityEdit{id}', [StudentController::class, 'activityEdit'])->name('studentActivityEdit');
    Route::get('/finishedActivity{id}', [StudentController::class, 'finishedActivity'])->name('finishedActivity');
    Route::put('/registerUpdate', [StudentController::class, 'registerUpdate'])->name('registerUpdate');
    Route::delete('/registerDelete', [StudentController::class, 'registerDelete'])->name('registerDelete');
    Route::post('/registerStore', [StudentController::class, 'create'])->name('registerStore');
    Route::post('/createFavorite', [StudentController::class, 'createFavorite'])->name('createFavorite');
    Route::delete('/cancelFavorite', [StudentController::class, 'cancelFavorite'])->name('cancelFavorite');
});
