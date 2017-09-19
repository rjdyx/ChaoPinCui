<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\Category;
use App\Model\Product;
use App\Model\Custom;
use IQuery;

class CategoryController extends Controller
{
	// 获取该类代表产品信息
	public function getProduct(Request $request)
	{
		$data = Product::where('category_id', $request->category_id)
				->orderBy('heat','desc')
				->first();
		return response()->json($data);
	}

	// 获取推荐产品信息
	public function getRecommend(Request $request)
	{
		$data = Product::where('category_id', $request->category_id)
			->orderBy('heat','desc')
			->offset(1)->limit(6)->get();
		return $data;
	}
}