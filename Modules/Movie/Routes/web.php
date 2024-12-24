<?php

use Illuminate\Support\Facades\Route;
use Modules\Movie\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'isEmployee'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::resource('/movie', MovieController::class);
    });

    Route::controller(MovieController::class)->group(function () {
        Route::patch('movie/{movie}/active', 'toggleActivation')->name('movie.active');
    });
});
