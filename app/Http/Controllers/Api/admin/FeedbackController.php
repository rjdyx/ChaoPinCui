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

    // 编辑
    public function edit($id)
    {
    	return Feedback::find($id);
    }

    // 编辑保存
    public function update(Request $request, $id)
    {
    	return $this->storeOrUpdate($request, $id);
    }

    // 新建保存
    public function store(Request $request)
    {
    	return $this->storeOrUpdate($request);
    }

    // 新建、编辑 保存方法
    private function storeOrUpdate($request, $id = -1)
    {
    	$this->validate($request, [
            'content' => 'required',
            'user_id' => 'required|exists:users'
        ]);

        if ($id == -1) {
        	$model = new Feedback;
        } else {
        	$model = Feedback::find($id);
        }

        $arr = ['content', 'user_id'];
        $model->setRawAttributes($request->only($arr));
        $res = IQuery::uploads($request, 'img');
        $model->img = $res['ps'];
        
        if (!$model->save()) return 0;
        if ($id != -1) $model->id = $id;
        return $model->id;
    }
}
