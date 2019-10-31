<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1', 'namespace' => 'API'], function () {
    // Product
    Route::get('get-products','ProductController@getProduct');
    Route::get('get-product-by-id/{id}','ProductController@getProductById');
    Route::get('get-product-by-catId/{cate_id}','ProductController@getProductByCatId');
    Route::post('add-new-product','ProductController@addProduct');

    //Authors
    Route::post('add-authors','AuthorController@addAuthor');

});
