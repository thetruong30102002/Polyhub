<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Bill\Http\Controllers\API\ApiBillController;

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
    Route::controller(ApiBillController::class)->group(function () {
        Route::get('/getBill', 'getBillByUser')->middleware('auth:api');
        Route::get('/getBillDetail/{id}', 'getBillDetail');
    });
});
Route::middleware('auth:api')->get('/bill', function (Request $request) {
    return $request->user();
});

Route::apiResource('bill', ApiBillController::class);

Route::post('vnPayCheckMail', [ApiBillController::class, 'vnPayCheckMail']);
Route::post('momoCheckMail', [ApiBillController::class, 'momoCheckMail']);
Route::post('paypalCheckMail', [ApiBillController::class, 'paypalCheckMail']);
