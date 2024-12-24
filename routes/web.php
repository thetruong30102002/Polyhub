<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BackendControllerBase;
use App\Http\Controllers\Backend\UserClientController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', [BackendControllerBase::class, 'index'])->name('admin.index');
    Route::prefix('admin')->group(function () {
        Route::middleware(['auth', 'isAdmin'])->group(function () {
            //User
            Route::resource('/user', UserController::class)->names([
                'index'   => 'user.index',
                'create'  => 'user.create',
                'store'   => 'user.store',
                'show'    => 'user.show',
                'edit'    => 'user.edit',
                'update'  => 'user.update',
                'destroy' => 'user.destroy',
            ]);
            Route::controller(UserController::class)->group(function () {
                Route::patch('user/{user}/active', 'toggleActivation')->name('user.active');
                Route::patch('/user/{id}/update-type', 'updateType')->name('user.updateType');
            });
            //UserClient
            Route::resource('/user-client', UserClientController::class)->names(['index'   => 'user.client.index']);
            Route::controller(UserClientController::class)->group(function () {
                Route::patch('user-client/{user}/active', 'toggleActivation')->name('user.client.active');
            });
        });
    });
});
//Auth
Route::controller(AuthController::class)->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', 'index')->name('auth.login');
        Route::post('/login', 'login')->name('auth.login.post');
    });
    Route::get('/logout', 'logout')->name('auth.logout');
});

Route::get('/products-data', [BackendControllerBase::class, 'getProductsData']);
