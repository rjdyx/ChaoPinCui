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
Route::get('auth',function() {
	return auth::user();
});

// 首页
Route::get('/', function () {
    return view('index');
});

Route::get('logout','Auth\LoginController@logout'); //登出
Route::get('categorys','Api\Home\IndexController@getCategorys'); 

//登录界面
Route::get('login',function() {
	return view('auth.login');
});

Auth::routes();
