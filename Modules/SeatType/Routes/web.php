<?php

use Illuminate\Support\Facades\Route;
use Modules\SeatType\Http\Controllers\SeatTypeController;
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
        Route::resource('seattype', SeatTypeController::class)->names([
            'index' => 'seattype.list',
            'store' => 'seattype.store',
            'create' => 'seattype.create',
            'show' => 'seattype.show',
            'edit' => 'seattype.edit',
            'update' => 'seattype.update',
            'destroy' => 'seattype.delete'
        ]);
    });
});
