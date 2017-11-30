<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//用户信息
Route::get('auth',function() {
	return response()->json(Auth::user());
});

//获取token
Route::get('/token',function() {
    return response()->json(csrf_token());
});

// 首页
Route::get('/', function () {
    return view('index');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('phone','HomeController@phone');
Route::get('get/openid','HomeController@getOpenid'); //获取openid

Route::get('logout','Auth\LoginController@logout'); //登出
Route::get('aaa' function() {
	return view('aaa');
});

Auth::routes();

// Api 接口
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {

	/********************* 公共 ***********************/
	Route::get('get/tables','UtilController@getTable');// 查询单张表数据
	Route::get('find/{$id}','UtilController@findTable');// 查询单表单条数据
	Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
		Route::delete('deletes','UtilController@deletes');// 批量删除
	});

	/********************* 后台 ***********************/
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
		Route::resource('index', 'IndexController'); //首页
		Route::group(['middleware' => 'UserAuth:admin'], function() {
			Route::resource('user', 'UserController'); // 用户管理
		});
		Route::resource('system', 'SystemController'); // 系统管理
		Route::resource('log', 'LogController'); // 操作日志管理
		Route::get('category/all', 'CategoryController@all'); // 分类管理
		Route::resource('category', 'CategoryController'); // 分类管理
		Route::resource('turn', 'ProductTurnController'); // 轮播图管理
		Route::resource('feedback', 'FeedbackController'); // 用户反馈
		Route::resource('category_child', 'CategoryChildController'); // 分类子类管理
		Route::resource('product', 'ProductController'); // 产品管理
		Route::resource('img', 'ImgController'); // 图片管理
		Route::resource('custom', 'CustomController'); // 自定义参数管理
		Route::resource('comment', 'CommentController'); // 评论管理
	});

	/********************* 前台 不登录 ***********************/
	Route::group(['prefix' => 'home', 'namespace' => 'Home'], function() {
		/* 登录、注册 */
		Route::get('wx/check','WxController@wxCheck');//微信解除绑定
		Route::post('wx/login','WxController@bindWeiXin');// 微信绑定账户登录
		Route::get('wx/wxlogin','WxController@wxLogin');// 微信账号登录
		Route::post('wx/register','WxController@bindWeiXinUserRegister');// 微信注册
		Route::get('wx/relieve','WxController@bindWeiXinRelieve');//微信解除绑定

		/* 首页 */
		Route::get('index/categorys', 'IndexController@getCategorys'); // 获取所有分类信息
		Route::get('index/recommend', 'IndexController@getRecommend'); // 获取推荐产品信息
		Route::get('index/turns', 'IndexController@getTurns'); // 获取轮播图

		/*分类页 */
		Route::get('category/product', 'CategoryController@getProduct'); // 获取该类代表产品
		Route::get('category/child', 'CategoryController@getChild'); // 获取该类下的二级分类
		Route::get('category/recommend', 'CategoryController@getRecommend'); // 获取产品推荐
		Route::get('category/other', 'CategoryController@getOther'); // 获取其它分类
		Route::get('category/rand', 'CategoryController@getRand'); // 获取随机分类
		Route::get('category/getCat', 'CategoryController@getCatRec'); // 获取各推荐分类

		/* 产品详情页 */
		Route::get('product/details', 'ProductController@productInfo'); // 获取产品信息
		Route::get('product/reload', 'ProductController@getReload'); // 获取评论加载信息
		Route::get('product/imgs', 'ProductController@productImgs'); // 获取产品图片信息
		Route::get('product/nearbys', 'ProductController@productNearby'); // 获取当前产品附近产品信息
		Route::get('product/lists', 'ProductController@productLists'); // 获取产品列表信息

		/* 获取附近住宿信息 */
		Route::get('near_hotel', 'NearHotelController@getNearHotelData');

		/* 公司信息（关于我们） */
		Route::get('company', 'SystemController@index');
	// });

	/********************* 前台 须登录 ***********************/
	// Route::group(['prefix' => 'home', 'namespace' => 'Home', 'middleware' => 'UserAuth:home'], function() {

		/* 个人中心、用户编辑页 */
		Route::post('user/img', 'UserController@uploadImg');
		Route::post('user/setUpdate', 'UserController@setUpdate');
		Route::post('user/password','UserController@resetPassword');//修改密码
		Route::resource('user', 'UserController');

		/* 我的收藏 */
		Route::get('collect/user', 'CollectController@userCollect'); // 收藏或取消
		Route::get('collect/cancel', 'CollectController@CancelCol'); // 收藏或取消
		Route::resource('collect', 'CollectController');

		/* 我的评论 */
		Route::post('comment/img', 'CommentController@uploadImg');
		Route::get('comment/check', 'CommentController@checkComment');
		Route::resource('comment', 'CommentController');

		/* 意见反馈 */
		Route::post('feedback/img', 'FeedbackController@uploadImg');
		Route::post('feedback', 'FeedbackController@store');
	});
});