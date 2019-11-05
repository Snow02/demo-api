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
    Route::get('get-list-authors','AuthorController@getListAuthors');
    Route::get('get-author/{id}','AuthorController@getAuthor');
    Route::put('update-author/{id}','AuthorController@updateAuthor');
    Route::delete('delete-author/{id}','AuthorController@deleteAuthor');
    Route::get('search-author/{data?}','AuthorController@searchAuthor');
    Route::get('get-list-articles-by-authorId/{id}','AuthorController@getListArticleByAuthorId');


    // Article
    Route::post('add-articles','ArticleController@add');
    Route::get('get-all-articles','ArticleController@showAll');
    Route::get('get-article-by-id/{id}','ArticleController@getArticleById');
    Route::put('update-article-by-id/{id}','ArticleController@updateArticleById');
    Route::delete('delete-article-by-id/{id}','ArticleController@deleteArticleById');
    Route::get('get-author-of-the-article/{id}','ArticleController@getAuthorOfTheArticle');
    Route::post('add-thumb-article/{id}','ArticleController@addThumbArticle');

    // Customer
    Route::post('add-customers','CustomerController@addCustomers');

    // Order
    Route::post('add-order-by-customer','OrderController@addOrder');
    Route::get('get-order-by-customer-id/{id}','OrderController@getOrderByCustomerId');
    Route::get('get-order-by-status-1','OrderController@getOrderHavePaid');
    Route::get('get-order-by-date/{date}','OrderController@getOrderByDate');
    Route::delete('delete-order/{id}','OrderController@DeleteOrder');
    Route::put('update-order/{id}','OrderController@updateOrderById');
    Route::put('update-order-by-customer/{customer_id}','OrderController@updateOrderByCustomerId');
    Route::get('get-order-by-status','OrderController@getOrderByStatus');



    // Order-detail


});
