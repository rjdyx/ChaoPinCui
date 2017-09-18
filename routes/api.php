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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('get/table','Api\UtilController@getTable');// 查询单张表数据
Route::get('deletes','Api\UtilController@deletes');// 批量删除

// Api 接口
Route::group(['namespace' => 'Api'], function() {

	/******* 后台 *********/
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'UserAuth:admin'], function() {
		Route::resource('user', 'UserController');
		Route::resource('system', 'SystemController');
		Route::resource('category', 'CategoryController');
		Route::resource('comment', 'CommentController');
		Route::resource('product', 'ProductController');
		Route::resource('turn', 'TurnController');
	});

	/******* 前台 *********/
	Route::group(['prefix' => 'home', 'namespace' => 'Home', 'middleware' => 'UserAuth:home'], function() {
		Route::resource('user', 'UserController');
		Route::resource('system', 'SystemController');
		Route::resource('category', 'CategoryController');
		Route::resource('comment', 'CommentController');
		Route::resource('product', 'ProductController');
		Route::resource('turn', 'TurnController');
	});
});