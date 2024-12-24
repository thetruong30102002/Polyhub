<?php

use Illuminate\Support\Facades\Route;
use Modules\FoodCombo\Http\Controllers\FoodComboController;
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
    Route::prefix('admin')->group(function () {
        Route::resource('foodcombos', FoodComboController::class);
    });
    Route::controller(FoodComboController::class)->group(function () {
        Route::patch('foodcombos/{foodCombo}/status', 'updateStatus')->name('foodcombos.updateStatus');
    });
});
