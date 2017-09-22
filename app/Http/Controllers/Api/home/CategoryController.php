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
		$data = Product::join('categories','products.category_id','=','categories.id')
				->where('categories.pid', '=', $request->category_id)
				->orderBy('products.heat','desc')
				->whereNull('products.deleted_at')
				->select('products.*')
				->first();
		return response()->json($data);
	}

	// 获取二级分类
	public function getChild(Request $request)
	{
		$data = Category::where('pid', $request->pid)->get();
			// ->offset(1)->limit(6)->get();
		return $data;
	}

	// 获取一级分类下的产品推荐
	public function getRecommend(Request $request)
	{	
		$num = $request->num?$request->num:6;
		$data = Product::join('categories','products.category_id','=','categories.id')
				->where('categories.pid', '=', $request->category_id)
				->orderBy('products.heat','desc')
				->whereNull('products.deleted_at')
				->select('products.*')
				->paginate($num);
		return $data;
	}
}