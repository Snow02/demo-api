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
    // Users
    Route::post('register','UserController@register');
    Route::post('confirm-register','UserController@confirmRegister');
    Route::post('login','UserController@login');
    Route::get('get-list-users','UserController@getListUsers');
    Route::put('edit-user/{id}','UserController@editUserById');
    Route::delete('delete-user/{id}','UserController@deleteUserById');
    Route::post('upload-images-user/{id}','UserController@uploadImages');



    Route::prefix('password')->group(function (){
        Route::post('send-mail-reset', 'PasswordResetController@sendMailResetPass');
        Route::get('find/{token}', 'PasswordResetController@find');
        Route::post('reset', 'PasswordResetController@resetPassword');
    });

    Route::group(['middleware'=>'auth:api'],function() {
        Route::get('get-user-login','UserController@getUserLogin');
        Route::get('logout','UserController@logout');
        Route::put('change-password','UserController@changePassword');
        Route::post('update-info-user-login','UserController@UpdateUserLogin');
        Route::get('delete-user-login','UserController@deleteUserLogin');



    });

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
    Route::post('send-mail-order','OrderController@sendMail');


    // Order-detail

    // Send mail
    Route::post('test-send-mail','UserController@sendMail');
    //
    Route::get('firebase','FirebaseController@sendNotification');
    Route::get('firebase/get-list-users','FirebaseController@getListUser');

    // FallBack
    Route::fallback(function(){
        return response()->json([
            'message' => 'Not Found ! No links match',
        ],404);
    });




});
