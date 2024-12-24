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
use Modules\Room\Http\Controllers\RoomController;

Route::middleware(['auth', 'isEmployee'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('room')->name('room.')->group(function () {
            Route::get('/', [RoomController::class, 'index'])->name('index');
            Route::get('/create', [RoomController::class, 'create'])->name('create');
            Route::post('/create', [RoomController::class, 'store'])->name('create');
            Route::get('/detail/{id}', [RoomController::class, 'show'])->name('show');
            Route::post('/update/{id}', [RoomController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [RoomController::class, 'destroy'])->name('destroy');
        });
    });
});
