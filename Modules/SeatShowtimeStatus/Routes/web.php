<?php

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
    Route::prefix('seatshowtimestatus')->group(function () {
        Route::get('/', 'SeatShowtimeStatusController@index');
    });
});
