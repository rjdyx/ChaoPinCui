<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\Category;
use App\Model\Product;
use App\Model\Turn;
use IQuery;

class IndexController extends Controller
{
	// 获取所有分类信息
	public function getCategorys() {
		$data = IQuery::redisGet('index_categorys');
		if (!isset($data)) {
			$data = Category::whereNull('pid')->get();
			IQuery::redisSet('index_categorys', $data);
		}
		return response()->json($data);
	}

	// 获取推荐产品信息
	public function getRecommend() {
		$data = IQuery::redisGet('index_recommend');
		if (!isset($data)) {
			$data = Product::orderBy('heat','desc')->paginate(4);
			IQuery::redisSet('index_recommend', $data);
		}
		return response()->json($data);
	}

	// 获取轮播图
	public function getTurns() {
		$data = IQuery::redisGet('index_turns');
		if (!isset($data)) {
			$data = Turn::where('state',1)->orderBy('sort','asc')->paginate(4);
			IQuery::redisSet('index_turns', $data);
		}
		return response()->json($data);
	}
}