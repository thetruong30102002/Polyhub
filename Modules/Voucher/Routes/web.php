<?php
use Illuminate\Support\Facades\Route;
use Modules\Voucher\Entities\Voucher;
use Modules\Voucher\Http\Controllers\VoucherController;

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
    //Route::get('/', 'voucherController@index');
    Route::resource('voucher',VoucherController::class)->names([
        'index' => 'voucher.list',
        'store' => 'voucher.store',
        'create' => 'voucher.create',
        'show' => 'voucher.show',
        'edit' => 'voucher.edit',
        'update' => 'voucher.update',
        'destroy' => 'voucher.delete'
    ]);
    Route::get('voucher/bin/voucher', 'VoucherController@bin')->name('voucher.bin');
   
});
});