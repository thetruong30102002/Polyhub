<?php

use Illuminate\Support\Facades\Route;
use Modules\AttributeValue\Http\Controllers\AttributeValueController;
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
        // Route::get('/', 'AttributeValueController@index');
        Route::resource('attributevalue', AttributeValueController::class)->names([
            'index' => 'attributevalue.list',
            'store' => 'attributevalue.store',
            'create' => 'attributevalue.create',
            'show' => 'attributevalue.show',
            'edit' => 'attributevalue.edit',
            'update' => 'attributevalue.update',
            'destroy' => 'attributevalue.delete'
        ]);
        Route::post('/attributevalue/search', 'AttributeValueController@search')->name('attributevalue.search');
        Route::get('/attributevalue/up', 'AttributeValueController@up')->name('attributevalue.up');
        Route::get('/attributevalue/down', 'AttributeValueController@down')->name('attributevalue.down');
        Route::get('/attributevalue/bin/attributevalue', 'AttributeValueController@bin')->name('attributevalue.bin');
    });
});
