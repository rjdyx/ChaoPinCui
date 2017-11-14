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
use IQuery;

class UtilController extends Controller
{
	/* 方法描述：查询某表指定条目或所有信息 
    * 参数：表名=>tname, 条件数组=>whs
    * 如：{ tname:'users', whs:['pid|!=|null','sex|=|0'], limit:10 }
    * 注：whs数组中每个字符串以‘|’拆分作为Where函数的参数, limit为0获取全部
    **/
    public function getTable(Request $request)
    {
        $tname = $request->tname;
        $whs = $request->whs;
        $limit = $request->limit;

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

        if ($limit) {
            $datas = $model->paginate($limit);
        } else {
            $datas = $model->get();
        }
        
    	return response()->json($datas);
    }

    /* 方法描述：查询某表单条信息 
    * 参数：Model=>tname, 主键=>id
    * Url : ** / 13 
    * 如：{ tname:'User'}
    **/
    public function findTable(Request $request, $id) 
    {
        $tname = $request->tname;
        if (empty($tname)) {
            return response()->json('Parameter error', 500);
        }
        $res = $tname::find($id);
        return $res;
    }

    /* 方法描述：删除某表指定ids信息 
    * 参数：Model=>tname, 条件数组=>ids
    * 如：{ tname:'User', ids:[1,2,3] }
    **/
    public function deletes(Request $request)
    {
        $tname = $request->tname;
        $ids = $request->ids;
        $res = $this->setMutilDel($tname, $ids);
        if ($res !== 'true') {
            return response()->json($res);
        }
        if (empty($tname) || !count($ids)) {
            IQuery::ofLog(strtolower($tname), 5, 1);
            return response()->json('Parameter error', 500);
        }

        $model = 'App\Model\\'."$tname";
        if (!$model::destroy($ids)) return response()->json('false');
        IQuery::ofLog(strtolower($tname), 5, 0);
        return response()->json('true');
    }

    /* 批量删除前置出处理
     * $tname 表类名，$ids多id
     */
    public function setMutilDel($tname, $ids) {
        $model = 'App\Model\\'."$tname";
        $sname = strtolower($tname);
        if ($sname == 'user') {
            foreach ($ids as $id) {
                if (Auth::user()->id == $id) {
                    return 'self';
                }
                $user = $model::find($id);
                if ($user->type == 1) {
                    return 'notallow';
                }
            }
        }
        // 批量删除图片
        foreach ($ids as $id) {
            $table = $model::find($id);
            $img = $table->img;
            $ico = $table->ico;
            IQuery::delImg($img);
            IQuery::delMosImg($img);
            IQuery::delImg($ico);
        }
        return 'true';
    }

}
