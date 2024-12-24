<?php

use Illuminate\Support\Facades\Route;
use Modules\RankMember\Http\Controllers\RankMemberController;

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
        Route::resource('/rankmember', RankMemberController::class)->names([
            'index'   => 'rankmember.index',
            'create'  => 'rankmember.create',
            'store'   => 'rankmember.store',
            'show'    => 'rankmember.show',
            'edit'    => 'rankmember.edit',
            'update'  => 'rankmember.update',
            'destroy' => 'rankmember.destroy',
        ]);
    });
});
