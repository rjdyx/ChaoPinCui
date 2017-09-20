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


// Api 接口
Route::group(['namespace' => 'Api'], function() {

	/********************* 公共 ***********************/
	Route::get('get/tables','UtilController@getTable');// 查询单张表数据
	Route::get('find/{$id}','UtilController@findTable');// 查询单表单条数据
	Route::group(['prefix' => 'admin', 'middleware' => 'UserAuth:admin'], function() {
		Route::delete('deletes','UtilController@deletes');// 批量删除
	});

	/********************* 后台 ***********************/
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

	/********************* 前台 ***********************/
	Route::group(['prefix' => 'home', 'namespace' => 'Home', 'middleware' => 'UserAuth:home'], function() {
		/* 登录 */
		Route::post('wx/bind','WxController@bindWeiXin');// 微信绑定账户登录
		Route::post('wx/register','WxController@bindWeiXinUserRegister');// 微信直接登录
		Route::get('wx/relieve','WxController@bindWeiXinRelieve');//微信解除绑定

		/* 首页 */
		Route::get('index/categorys', 'IndexController@getCategorys'); // 获取所有分类信息
		Route::get('index/recommend', 'IndexController@getRecommend'); // 获取推荐产品信息

		/*分类页 */
		Route::get('category/product', 'CategoryController@getProduct'); // 获取该类代表产品
		Route::get('category/recommend', 'CategoryController@getRecommend'); // 获取该类推荐产品

		/* 产品详情页 */
		Route::get('product/details', 'ProductController@productInfo'); // 获取产品信息
		Route::get('product/imgs', 'ProductController@productImgs'); // 获取产品图片信息
		Route::get('product/nearbys', 'ProductController@productNearby'); // 获取当前产品附近产品信息
		Route::get('product/lists', 'ProductController@productLists'); // 获取产品列表信息

		/* 个人中心、用户编辑页 */
		Route::resource('user', 'UserController');
	});

});