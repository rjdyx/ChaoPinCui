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
		Route::resource('index', 'IndexController'); //首页
		Route::resource('user', 'UserController'); // 用户管理
		Route::resource('system', 'SystemController'); // 系统管理
		Route::resource('turn', 'TurnController'); // 轮播图管理
		Route::resource('category', 'CategoryController'); // 分类管理
		Route::resource('product', 'ProductController'); // 产品管理
		Route::resource('img', 'ImgController'); // 图片管理
		Route::resource('custom', 'CustomController'); // 自定义参数管理
		Route::resource('comment', 'CommentController'); // 评论管理
	});

	/******* 前台 *********/
	Route::group(['prefix' => 'home', 'namespace' => 'Home', 'middleware' => 'UserAuth:home'], function() {
		Route::post('wx/bind','WxController@bindWeiXin');// 微信绑定账户登录
		Route::post('wx/register','WxController@bindWeiXinUserRegister');// 微信直接登录
		Route::get('wx/relieve','WxController@bindWeiXinRelieve');//微信解除绑定
		Route::get('index', 'IndexController@index'); //首页
	});

});