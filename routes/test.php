<?php

use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', [IndexController::class, 'test'])->name('test');
