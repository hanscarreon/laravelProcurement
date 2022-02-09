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
Route::post('user/register','accountsController@registerUser');
Route::post('bid/submit','bidController@submitBid');
Route::get('product/list/{id}','product\ProductController@getProducts');
Route::post('product/create','product\ProductController@createProduct');
Route::get('product/get/one/{id}','product\ProductController@getProductById');
Route::get('profile/{id}','user\ProfileController@getUser');
Route::post('profile/update/{id}','user\ProfileController@updateProfile');
Route::post('product/update/{id}','product\ProductController@updateProduct');
Route::get('product/delete/{id}','product\ProductController@deleteProduct');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


