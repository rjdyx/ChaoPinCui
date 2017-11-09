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
use App\Model\Collect;
use App\Model\Img;
use IQuery;
use DB;
use Session;

class ProductController extends Controller
{

	// 产品基础信息
	public function productInfo(Request $request)
	{
		$info = Product::join('categories','products.category_id','=','categories.id')->where('categories.deleted_at')
			->join('categories as parent','categories.pid','=','parent.id')->where('parent.deleted_at')
			->where('products.id','=',$request->id)
			->select('products.*','parent.name as parent_name','categories.name as category_name', 'parent.id as parent_id')
			->first();
		$model = Collect::where('product_id',$request->id)->where('user_id', $request->user_id)->first();
		$isCollect = isset($model->id)?1:0;
		$info->is_collect = $isCollect;
		$recommend = $this->productCustoms($request->id);
		$comment = $this->getInfoData($request->id);
		$res = ['info'=>$info, 'recommend'=>$recommend, 'comment'=>$comment[0], 'totalComment'=>$comment[1]];
		return response()->json($res);
	}

	// 获取产品自定义信息
	public function productCustoms($id)
	{
		return Custom::where('product_id', $id)->get();
	}

	// 获取加载下信息
	public function getReload(Request $request) {
		$page = $request->page;
        $page = isset($page) ? $page : '';
        if($page != '') {
            $request->merge(['page'=>$page]);
        }
        $data = $this->getInfoData($request->id);
        return $data[0];
	}

	// 获取产品评论信息
	public function getInfoData($id) {
		$data = Comment::join('users','comments.user_id','=','users.id')->whereNull('users.deleted_at')
			->join('products','comments.product_id','=','products.id')->whereNull('products.deleted_at')
			->where('comments.product_id', $id)
			->orderBy('created_at','desc')
			->select('comments.*','users.img as user_img', 'users.name as user_name','products.comment as count_comment');
	    $totalComment = $data->sum('comments.level');
		$dataComment = $data ->paginate(10);
		return [$dataComment, $totalComment];
	}

	// 获取产品图片信息
	public function productImgs(Request $request)
	{
		return Img::where('product_id', $request->product_id)->orderBy('sort','desc')->get();
	}

	// 获取产品附近产品信息
	public function productNearby(Request $request)
	{
		$id = $request->id;
		if (!$id) return response()->json('参数错误！', 500);

		$pt = Product::find($id);

		$res = Product::where('category_id', $pt->category_id)
			->select('products.*')
			->orderBy('desc')
			->paginate(6);
		return $res;
	}

	// 获取产品列表信息
	public function productLists(Request $request)
	{
		$type = $request->type; // 产品类型（推荐、附近）
		$cid = $request->category_id; // 分类id
		$pid = $request->parent_id; // 父分类id
		$id = $request->id; // 产品id
		$name = $request->name;
		$page = $request->page;
        $page = isset($page) ? $page : '';
        if($page != '') {
            $request->merge(['page'=>$page]);
        }
        if (isset($cid)) {
        	$aheat = Session::get('sessionHeat_'.$cid);
        	if ($aheat != null) {
        		$aheat += 1;
        	} else {
        		$aheat = 1;
        	}
        	Session::put('sessionHeat_'.$cid, $aheat);
        }
		$data = $this->getCategoryProduct($id, $cid, $pid, $type, $name);
		return response()->json($data);
	}

	//获取普通分类的列表产品/附近
	public function getCategoryProduct($id, $cid, $pid, $type, $name='')
	{
		$data = Product::join('categories','products.category_id','=','categories.id')->whereNull('categories.deleted_at')
		               ->whereNotNull('categories.pid')
		               ->join('categories as parent', 'parent.id', '=', 'categories.pid')->whereNull('parent.deleted_at')
		               ->whereNull('parent.pid');

		if ($type == 'nearby') {
			$data = $data->where('parent.id', $pid);
		} else if ($type == 'category') {
			$data = $data->where('products.category_id', $cid);
		} else if ($type == 'search') {
			$data = $data->where('products.name','like','%'.$name.'%')
			        ->where('categories.pid','=',$id);
		} else if ($type == 'recommend') {
			$data = $data->where('categories.pid','=',$id);
		}
		$data = $data->select('products.*')
			  ->orderBy('desc')
			  ->paginate(5);
		return $data;
	}

	//推荐列表信息
	public  function recommendList($cid)
	{
		$data = Product::join('categories','products.category_id','=','categories.id')
			->where('categories.pid','=',$cid)
			->orderBy('products.heat','desc')
			->get();
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