<?php
/**
 * controller: System
 * autoer: guosenlin
 * date: 2017/09/14
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Log;
use IQuery;

class LogController extends Controller
{
    public function index(Request $request) {
        $datas = Log::join('users','logs.user_id','=','users.id')->whereNull('users.deleted_at')
                ->orderBy('created_at','desc')->select('logs.*','users.name as user_name');
        $datas = IQuery::ofText($datas,$request->query_text,'log',['logs.name']);
        $datas = $datas->paginate(config('app.page'));
        return response()->json($datas);
    }

    // 查看
    public function show()
    {
    	return System::first();
    }

    // 单条删除
    public function destroy($id)
    {
        if (Log::destroy($id)) {
            IQuery::ofLog('log', 4, 0);
            return $id;
        }
        IQuery::ofLog('log', 4, 1);
        return 0;
    }
}
