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
	public function getProduct(Request $request) {
		$data = IQuery::redisGet('category_product_'.$request->category_id);  //获取redis缓存数据
		if (!isset($data)) {
			$data = Product::join('categories','products.category_id','=','categories.id')
					->where('categories.pid', '=', $request->category_id)
					->orderBy('products.heat','desc')
					->whereNull('products.deleted_at')
					->select('products.*')
					->first();
			IQuery::redisSet('category_product_'.$request->category_id, $data);
		}
		return $data;
	}

	// 获取二级分类
	public function getChild(Request $request) {
		$data = IQuery::redisGet('category_child_'.$request->pid);
		if (!isset($data)) {
			$data = Category::where('pid', $request->pid)->get();
			foreach($data as $d) {
				$d->tap_head = Redis::get('sessionHeat_'.($d->id)) != null ? Redis::get('sessionHeat_'.($d->id)) : 0;
			}
			IQuery::redisSet('category_child_'.$request->pid, $data);
		}
		return $data;
	}

	// 获取一级分类下的产品推荐
	public function getRecommend(Request $request) {	
		$data = IQuery::redisGet('category_recommend_'.$request->category_id);
		if (!isset($data)) {
			$num = $request->num?$request->num:4;
			$data = Product::join('categories','products.category_id','=','categories.id')
					->where('categories.pid', '=', $request->category_id)
					->orderBy('products.heat','desc')
					->whereNull('categories.deleted_at')
					->select('products.*')
					->paginate($num);
			IQuery::redisSet('category_recommend_'.$request->category_id, $data);
		}
		// 
		return response()->json($data);
	}

	// 获取各分类产品推荐
	public function getCatRec(Request $request) {
		$data = Product::join('categories','products.category_id','=','categories.id')
			->where('categories.pid', '=', $request->category_id)
			->orderBy('products.heat','desc')
			->whereNull('categories.deleted_at')
			->select('products.*')
			->groupBy('categories.id')
			->limit(2)
			->get();
		return $data;
	}

	// 获取其它分类
	public function getOther(Request $request) {
		$data = IQuery::redisGet('category_other_'.$request->id);
		if (!isset($data)) {
			$data = Category::whereNull('pid')
					->where('id', '!=', $request->id)
					->paginate(8);
			IQuery::redisSet('category_other_'.$request->id, $data);
		}
		return response()->json($data);
	}

	// 获取随机分类
	public function getRand(Request $request) {
		$data = IQuery::redisGet('category_rand');
		if (!isset($data)) {
			$data = Category::whereNull('pid')
					->inRandomOrder()
					->paginate(6);
			IQuery::redisSet('category_rand', $data);
		}
		return response()->json($data);
	}
}