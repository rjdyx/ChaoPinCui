<?php
/**
 * controller: Feedback
 * autoer: guosenlin
 * date: 2017/09/18
*/
namespace App\Http\Controllers\Api\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Feedback;
use IQuery;

class FeedbackController extends Controller
{
	// 新建、编辑 保存方法
    public function store(Request $request, $id = -1)
    {
    	$this->validate($request, [
            'content' => 'required'
        ]);

        if ($id == -1) {
        	$model = new Feedback;
        } else {
        	$model = Feedback::find($id);
        }

        $arr = ['content', 'user_id', 'img'];
        $model->setRawAttributes($request->only($arr));
        
        if (!$model->save()) return 0;
        if ($id != -1) $model->id = $id;
        return $model->id;
    }

    //上传图片
    public function uploadImg(Request $request)
    {
        return IQuery::uploads($request, 'img');
    }
}