<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [DashboardController::class, 'anyIndexPage']);

