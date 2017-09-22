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

class CollectController extends Controller
{
	// 全部收藏信息
    public function index(Request $request)
    {
    	$datas = Collect::join('products','collects.product_id','=','products.id')
            ->where('collects.user_id', '=', Auth::user()->id)
            ->orderBy('collects.created_at','desc')
            ->select('products.*', 'collects.id as collect_id')
            ->get();
    	return response()->json($datas);
    }

    // 单条删除
    public function destroy($id)
    {
    	if (Collect::destroy($id)) return $id;
    	return 0;
    }
}
