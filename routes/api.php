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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('auth/login', 'Api\AuthController@login')->name('login');

Route::group(['middleware'=>['apiJwt']], function() {
  Route::apiResource('/categories','Api\CategoryController');
  Route::apiResource('/products','Api\ProductController');
  Route::apiResource('/orders','Api\OrderController');
  Route::apiResource('/users','Api\UserController');
  Route::apiResource('/order-items','Api\OrderItemController');
});

Route::get('/products', 'Api\ProductController@index');

/*

Route::group(['middleware'=>['apiJwt']], function() {
  Route::apiResource('posts','Api\PostController')
        ->names([
          'index'   =>    'api.posts.index',
          'show'    =>    'api.posts.show',
          'store'   =>    'api.posts.store',
          'update'  =>    'api.posts.update',
          'destroy' =>    'api.posts.destroy'
        ]);
});


*/
