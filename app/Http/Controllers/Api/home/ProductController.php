<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\Category;
use App\Model\Custom;
use App\Model\Comment;
use App\Model\Product;
use App\Model\Img;
use IQuery;
use DB;

class ProductController extends Controller
{
	// 产品基础信息
	public function productInfo(Request $request)
	{
		$info = Product::find($request->id);
		$recommend = $this->productCustoms($request->id);
		$comment = $this->getComment($request->id);
		$res = ['info'=>$info, 'recommend'=>$recommend, 'comment'=>$comment];
		return response()->json($res);
	}

	// 获取产品自定义信息
	public function productCustoms($id)
	{
		return Custom::where('product_id', $id)->get();
	}

	// 获取产品评论信息
	public function productComment($id)
	{
		return Comment::where('product_id', $id)->get();
	}

	// 获取产品图片信息
	public function productImgs(Request $request)
	{
		return Img::where('product_id', $request->product_id)->orderBy('sort','desc')->get();
	}

	// 获取产品附近产品信息
	public function productNearby(Request $request)
	{
		$lon = $request->lon;
		$lat = $request->lat;
		$id = $request->id;
		if (!$lon && !$lat && !$id) return response()->json('参数错误！', 500);

		$pt = Product::find($id);
		$distance = ACOS(SIN(($lat * 3.1415) / 180 ) * SIN(('weft' * 3.1415) / 180 ) +COS(($lat * 3.1415) / 180 ) * COS(('weft' * 3.1415) / 180 ) * COS(($lon * 3.1415) / 180 - ('meridian' * 3.1415) / 180 ) ) * 6380;

		$res = Product::where('category_id', $pt->category_id)
			->select(DB::raw($distance.' as dis, products.*'))
			->orderBy('dis', 'desc')
			->paginate(6);
		return $res;
	}

	// 获取产品列表信息
	public function productLists(Request $request)
	{
		$type = $request->type; // 产品类型（推荐、附近）
		$cid = $request->category_id; // 分类id
		if ($type == 'recommend') {
			$data = $this->getRecommend($cid);
		}
		return $data;
	}

	// 获取推荐产品信息
	public function getRecommend($cid)
	{
		$data = Product::where('category_id', $cid)
			->orderBy('heat','desc')
			->offset(1)
			->limit(6)
			->get();
		return $data;
	}
}