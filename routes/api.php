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
// register

Route::prefix('profile')->group(function () {
    Route::get('/{id}', 'user\ProfileController@getUser');
    Route::post('/update/{id}', 'user\ProfileController@updateProfile');
    Route::post('/update/social/{id}', 'user\ProfileController@submitUpdateSocialProfile');
});

Route::prefix('product')->group(function () {
    Route::get('list/{id}', 'product\ProductController@getProducts');
    Route::post('create', 'product\ProductController@createProduct');
    Route::get('get/one/{id}', 'product\ProductController@getProductById');
    Route::post('update/{id}', 'product\ProductController@updateProduct');
    Route::get('delete/{id}', 'product\ProductController@deleteProduct');
});

Route::post('user/register', 'accountsController@registerUser');

route::prefix('bid')->group(function () {
    Route::post('submit', 'bidController@submitBid');
    Route::get('get/{id}', 'bidController@getProductBid');
});


Route::get('bid/home/get/all', 'home\HomeController@getAllProducts');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
