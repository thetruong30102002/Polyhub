<?php

use Illuminate\Support\Facades\Route;
use Modules\CinemaType\Http\Controllers\CinemaTypeController;

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
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('cinematype')->name('cinematype.')->group(function () {
            Route::get('/', [CinemaTypeController::class, 'index'])->name('index');
            Route::get('/create', [CinemaTypeController::class, 'create'])->name('create');
            Route::post('/create', [CinemaTypeController::class, 'store'])->name('create');
            Route::get('/detail/{id}', [CinemaTypeController::class, 'show'])->name('detail');
            Route::post('/update/{id}', [CinemaTypeController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CinemaTypeController::class, 'destroy'])->name('delete');
        });
    });
});
