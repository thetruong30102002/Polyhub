<?php

use Illuminate\Support\Facades\Route;
use Modules\Actor\Http\Controllers\ActorController;

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
        //Route::get('/', 'ActorController@index');
        Route::resource('actor', ActorController::class)->names([
            'index' => 'actor.list',
            'store' => 'actor.store',
            'create' => 'actor.create',
            'show' => 'actor.show',
            'edit' => 'actor.edit',
            'update' => 'actor.update',
            'destroy' => 'actor.delete'
        ]);
        Route::get('actor/search/Actor', 'ActorController@search')->name('actor.search');
        Route::get('actor/filter/Actor', [ActorController::class, 'filter'])->name('actor.filter');
        Route::get('actor/up', 'ActorController@up')->name('actor.up');
        Route::get('actor/down', 'ActorController@down')->name('actor.down');
        Route::get('actor/bin/actor', 'ActorController@bin')->name('actor.bin');
        Route::get('actor/restore/{id}', 'ActorController@restore')->name('actor.restore');
        Route::get('actor/forceDelete/{id}', 'ActorController@forceDelete')->name('actor.forceDelete');
    });
});
