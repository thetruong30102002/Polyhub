<?php

use Illuminate\Support\Facades\Route;
use Modules\ShowingRelease\Http\Controllers\ShowingReleaseController;
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
        Route::resource('showingrelease', ShowingReleaseController::class);
        Route::get('/cinemas/{cityId}', [ShowingReleaseController::class, 'getCinemasByCity']);
        Route::get('/rooms/{cinemaId}', [ShowingReleaseController::class, 'getRoomsByCinema']);
        Route::get('/movies', [ShowingReleaseController::class, 'getAllMovies']);
        Route::get('/showingreleases/{movieId}/{cinemaId}', [ShowingReleaseController::class, 'getShowingReleasesByMovie']);
        Route::get('/showingrelease/create/{cinemaId?}', [ShowingReleaseController::class, 'create']); // Thay đổi ở đây
        
    });
});
