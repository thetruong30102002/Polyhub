<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Director\Http\Controllers\API\DirectorController ;

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

Route::middleware('auth:api')->get('/director', function (Request $request) {
    return $request->user();
});

Route::resource('director',DirectorController::class);