<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Modules\ShowingRelease\Http\Controllers\api\ShowingReleaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->group(function () {
    Route::apiResource('showingrelease', ShowingReleaseController::class);
    Route::controller(ShowingReleaseController::class)->group(function () {
        Route::get('showingrelease/{showtime_id}/seats', 'getSeatsByShowtime');
        Route::post('/showingrelease/{showtime_id}/{seat_id}/status', 'updateSeatStatus');
        Route::get('/seattypes', 'getSeatType');
        Route::get('/showingrelease/{movie_id}/movie', 'getShowingbyMovie');
        Route::get('/showingrelease/{id}/status', 'getStatusSeat');
        
    });
});
