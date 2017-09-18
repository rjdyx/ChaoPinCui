<?php
/**
 * controller: Util 工具类
 * autoer: guosenlin
 * date: 2017/09/15
*/
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use DB;

class UtilController extends Controller
{
	/* 方法描述：查询某表所有信息 
    * 参数：表名=>tname, 条件数组=>whs
    * 如：{ tname:'users', whs:['pid|!=|null','sex|=|0'] }
    * 注：whs数组中每个字符串以‘|’拆分作为Where函数的参数
    **/
    public function getTable(Request $request)
    {
        $tname = $request->tname;
        $whs = $request->whs;

        if (empty($tname)) {
            return response()->json('Parameter error', 500);
        }

    	$model = DB::table($tname)->whereNull('deleted_at');
        if (!empty($whs) && count($whs)) {
            foreach ($whs as $wh) {
                $arr = explode('|', $wh);
                if (count($arr)<3) continue;
                $model = $model->where($arr[0], $arr[1], $arr[2]);
            }
        }
        $datas = $model->get();
    	return response()->json($datas);
    }

    /* 方法描述：查询某表所有信息 
    * 参数：Model=>tname, 条件数组=>ids
    * 如：{ tname:'User', ids:[1,2,3] }
    **/
    public function deletes(Request $request)
    {
        $tname = $request->tname;
        $ids = $request->ids;

        if (empty($tname) || !count($ids)) {
            return response()->json('Parameter error', 500);
        }
        if (!$model::destroy($ids)) return response()->json(0);
        return response()->json(1);
    }
}
