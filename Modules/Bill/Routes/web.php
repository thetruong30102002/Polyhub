<?php

use Illuminate\Support\Facades\Route;
use Modules\Bill\Http\Controllers\BillController;

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
Route::prefix('admin')->group(function() {
    Route::resource('bill', BillController::class);
});

Route::get('/print-bill/{id}', [BillController::class, 'printBill'])->name('print.bill');
});