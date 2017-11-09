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
use Illuminate\Support\Facades\Redis;

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
		foreach($data as $d) {
			$d->tap_head = Redis::get('sessionHeat_'.($d->id)) != null ? Redis::get('sessionHeat_'.($d->id)) : 0;
		}
		$data->orderBy('tap_head','desc');
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
		return response()->json($data);
	}

	// 获取其它分类
	public function getOther(Request $request)
	{
		$data = Category::whereNull('pid')
				->where('id', '!=', $request->id)
				->paginate(8);
		return response()->json($data);
	}

	// 获取随机分类
	public function getRand(Request $request)
	{
		$data = Category::whereNull('pid')
				->inRandomOrder()
				->paginate(6);
		return response()->json($data);
	}
}