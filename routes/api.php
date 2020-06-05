<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function(){
    Route::name('products.')->group(function(){
        Route::resource('products', 'ProductsController');
    });
    Route::name('tags.')->group(function(){
        Route::resource('tags', 'TagsController');
    });
    Route::name('images.')->prefix('images')->group(function(){
        Route::delete('/{id}', 'ProductImagesController@remove')->name('delete');
        Route::patch('/set-thumb/{photoId}/{realStateId}', 'ProductImagesController@setThumb')->name('setThumb');
    });
});