<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/swiper_test', [IndexController::class, 'swiper_test'])->name('swiper_test');

Route::get('/test', [IndexController::class, 'test'])->name('test');
