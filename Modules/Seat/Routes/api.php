<?php

use Illuminate\Http\Request;
use Modules\Seat\Http\Controllers\Api\SeatController;

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

Route::middleware('auth:api')->get('/seat', function (Request $request) {
    return $request->user();
});

Route::apiResource('seats', SeatController::class);