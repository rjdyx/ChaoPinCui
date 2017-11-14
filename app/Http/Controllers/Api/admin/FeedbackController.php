<?php
/**
 * controller: Feedback
 * autoer: guosenlin
 * date: 2017/09/19
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Feedback;
use IQuery;

class FeedbackController extends Controller
{
	// 分页信息
    public function index(Request $request)
    {
    	$datas = Feedback::join('users','feedbacks.user_id','=','users.id')->whereNull('users.deleted_at')
                ->orderBy('created_at','desc')->select('feedbacks.*','users.name as user_name');
                $datas = IQuery::ofText($datas,$request->query_text,'feedback', ['users.name']);
                $datas = $datas->paginate(config('app.page'));
    	return response()->json($datas);
    }

    // 查看
    public function show($id)
    {
    	return Feedback::find($id);
    }

    // 单条删除
    public function destroy($id)
    {
        $feedback = Feedback::find($id);
        IQuery::delMosImg($feedback->img);
    	if (Feedback::destroy($id)) {
            IQuery::ofLog('feedback', 4, 0);
            return $id;
        }
        IQuery::ofLog('feedback', 4, 1);
    	return 0;
    }
}
