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

Route::middleware('auth:api')->group(function () {
    Route::get('category/{id}/articles', 'CategoryController@getRelatedArticles');
    Route::get('category/tree', 'CategoryController@tree');

    Route::middleware('admin')->group(function () {
        Route::apiResource('user', 'UserController');
        Route::apiResource('article', 'ArticleController');
        Route::apiResource('category', 'CategoryController');
    });
    Route::get('article/{article}', 'ArticleController@show');

});

Route::post('signUp', 'UserController@store');
Route::post('signIn', 'AuthController@signIn');
Route::post('validateToken', 'AuthController@validateToken');
