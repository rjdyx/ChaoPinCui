<?php
/**
 * controller: Collect
 * autoer: guosenlin
 * date: 2017/09/14
*/
namespace App\Http\Controllers\Api\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Collect;
use IQuery;
use DB;

class CollectController extends Controller
{
	// 全部收藏信息
    public function index(Request $request)
    {
    	$datas = Collect::join('products','collects.product_id','=','products.id')
            ->where('collects.user_id', '=', $request->user_id)
            ->orderBy('collects.created_at','desc')
            ->select('products.*', 'collects.id as collect_id')
            ->get();
    	return response()->json($datas);
    }

    // 收藏与取消
    public function userCollect(Request $request)
    {
        $type = $request->type;
        if ($type=='true') return $this->collect($request);
        return $this->collectCancell($request);    
    }

    // 收藏
    public function collect($request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $model = new Collect;
        $model->user_id = $user_id;
        $model->product_id = $product_id;
        if ($model->save()) return $model->id;
        return 0;
    }

    // 取消收藏
    public function collectCancell($request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $model = Collect::where('product_id', $product_id)->where('user_id', $user_id)->first();
        return Collect::destroy($model->id);  
    }
}
