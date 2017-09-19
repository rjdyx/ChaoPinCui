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

class CategoryController extends Controller
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
		$pt = Product::find($request->id);
		$res = Product::->orderBy('sort','desc')->get();
	}
}