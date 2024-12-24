<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\API\BlogController;

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

Route::middleware('auth:api')->get('/blog', function (Request $request) {
    return $request->user();
});

Route::resource('blog',BlogController::class);
Route::get('blog-home', [BlogController::class, 'bloghome']);
Route::get('blog-categories', [BlogController::class, 'getAllCategory']);
Route::get('blog-by-category/{categoryID}', [BlogController::class, 'getBlogByCategory']);
Route::get('top-bogs', [BlogController::class, 'getTopBlogs']);
Route::get('blog-search', [BlogController::class, 'search'])->name('search');
Route::get('blog-hot', [BlogController::class, 'bloghome1']);
Route::get('blog-lastest', [BlogController::class, 'getLatestBlogs'])->name('search');
