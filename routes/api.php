<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\api\AuthClientController;
use App\Http\Controllers\Backend\BackendControllerBase;

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
    //Auth
    Route::controller(AuthClientController::class)->group(function () {
        Route::post('/signin', 'signin')->name('signin');
        Route::post('/signout', 'signout');
        Route::post('/signup', 'signup');
        Route::get('/user', 'getUser')->middleware('auth:api');
        Route::put('/user', 'updateUser')->middleware('auth:api');
        Route::get('/getbill','getBill')->middleware('auth:api');
    });

    //Statistical
    Route::get('/ticket-movie-data', [BackendControllerBase::class, 'getProductsData']);
    Route::get('/movie-ticket-data', [BackendControllerBase::class, 'getMovieTicketData']);
    Route::get('/payment-methods-data', [BackendControllerBase::class, 'getPaymentMethodsData']);
    Route::get('/ticket-amount-data', [BackendControllerBase::class, 'getTicketAmountData']);
    Route::get('/voucher-usage-data', [BackendControllerBase::class, 'getVoucherUsageData']);
    Route::get('/recent-purchasers-data', [BackendControllerBase::class, 'getRecentPurchasersData']);
    Route::get('/customer-data', [BackendControllerBase::class, 'getCustomerData']);
    Route::get('/client-locations', [BackendControllerBase::class, 'getClientLocations']);
    Route::get('/booked-movies', [BackendControllerBase::class, 'getBookedMovies']);
    Route::get('/get-top-movies', [BackendControllerBase::class, 'getTopMovies']);
});
