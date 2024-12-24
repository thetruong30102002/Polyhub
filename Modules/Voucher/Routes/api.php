<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Voucher\Http\Controllers\API\VoucherAPIController;
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
Route::resource('voucher', VoucherAPIController::class);
Route::get('voucher/{id}/amount', [VoucherAPIController::class, 'getAmountById']);
Route::post('voucher/name', [VoucherAPIController::class, 'getVoucherByName']);
Route::post('voucher/applyvoucher', [VoucherAPIController::class, 'applyVoucher']);