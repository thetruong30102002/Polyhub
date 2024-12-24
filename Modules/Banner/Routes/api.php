<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\api\BannerController;


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
Route::middleware('auth:api')->get('/banners', function (Request $request) {
    return $request->user();
});
Route::apiResource('banners', BannerController::class);
Route::get('banner-home', [BannerController::class, 'getBanner']);
Route::get('hot-banner', [BannerController::class, 'getHotBanner']);