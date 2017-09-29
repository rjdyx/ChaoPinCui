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
        if ($type)return $this->collect($request);
        return $this->collectCancell($request);    
    }

    // 收藏
    public function collect($request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        //获取软删除模型
        $cts = Collect::onlyTrashed()->where('product_id', $product_id)
            ->where('user_id', $user_id)->first();

        // 判断是否以前收藏过    
        if (isset($cts->id)) {
            if ($cts->restore()) return $cts->id; //恢复软删除
            return 0;
        } else {
            $model = new Collect;
            $model->user_id = $user_id;
            $model->product_id = $product_id;
            if ($model->save()) return $model->id;
            return 0;
        }
    }

    // 取消收藏
    public function collectCancell($request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $model = Collect::where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->first();
        return $this->destroy($model->id);   
    }

    // 单条删除
    public function destroy($id)
    {
    	if (Collect::destroy($id)) return $id;
    	return 0;
    }
}
