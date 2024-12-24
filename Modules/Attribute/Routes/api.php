<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Attribute\Http\Controllers\API\AttributeController;
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

// Route::middleware('auth:api')->get('/attribute', function (Request $request) {
//     return $request->user();
// });

Route::resource('attribute', AttributeController::class);