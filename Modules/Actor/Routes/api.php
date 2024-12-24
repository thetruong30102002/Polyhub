<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Actor\Http\Controllers\API\ActorController;

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

// Route::middleware('auth:api')->get('/actor', function (Request $request) {
//     return $request->user();
// });
Route::resource('actor', ActorController::class);