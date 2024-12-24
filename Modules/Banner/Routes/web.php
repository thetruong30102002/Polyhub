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
use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\BannerController;

Route::middleware(['auth', 'isEmployee'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::resource('banners', BannerController::class);
    });
    Route::controller(BannerController::class)->group(function () {
        Route::patch('banners/{banner}/status', 'updateStatus')->name('banners.updateStatus');
    });
});
