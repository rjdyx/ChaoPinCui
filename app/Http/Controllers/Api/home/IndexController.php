<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\Category;
use App\Model\Product;
use IQuery;
use Redirect;
use Session;

class IndexController extends Controller
{
	// 获取所有分类信息
	public function getCategorys()
	{
		$data = Category::whereNull('pid')->get();
		return response()->json($data);
	}

	// 获取推荐产品信息
	public function getRecommend()
	{
		$data = Product::orderBy('heat','desc')->paginate(4);
		return response()->json($data);
	}
}