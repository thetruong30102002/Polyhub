<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\AttributeValue\Http\Controllers\API\AttributeValueController;
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

// Route::middleware('auth:api')->get('/attributevalue', function (Request $request) {
//     return $request->user();
// });
Route::resource('attributevalue', AttributeValueController::class);