<?php

use Illuminate\Support\Facades\Route;
use Modules\Attribute\Http\Controllers\AttributeController;
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
        Route::resource('attribute', AttributeController::class)->names([
            'index' => 'attribute.list',
            'store' => 'attribute.store',
            'create' => 'attribute.create',
            'show' => 'attribute.show',
            'edit' => 'attribute.edit',
            'update' => 'attribute.update',
            'destroy' => 'attribute.delete'
        ]);
        Route::post('/attribute/search', 'AttributeController@search')->name('attribute.search');
        Route::get('/attribute/up', 'AttributeController@up')->name('attribute.up');
        Route::get('/attribute/down', 'AttributeController@down')->name('attribute.down');
        Route::get('/attribute/bin/attribute', 'AttributeController@bin')->name('attribute.bin');
        Route::get('attribute/restore/{id}', 'AttributeController@restore')->name('attribute.restore');
        Route::get('attribute/forceDelete/{id}', 'AttributeController@forceDelete')->name('attribute.forceDelete');
    });
});
