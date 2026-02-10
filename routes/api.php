<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MathController;

Route::prefix('math')->group(function () {
    Route::prefix('primes')->group(function () {
        Route::get('/', [MathController::class, 'primes']);
    });

    Route::prefix('fibonacci')->group(function () {
        Route::get('/', [MathController::class, 'fibonacci']);
    });

    Route::prefix('multiple')->group(function () {
        route::get('/', [MathController::class, 'multiple']);
    });

    Route::get('/all', [MathController::class, 'getList']);
});

