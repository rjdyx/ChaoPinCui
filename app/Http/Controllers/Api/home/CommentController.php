<?php
/**
 * controller: Comment
 * autoer: guosenlin
 * date: 2017/09/14
*/
namespace App\Http\Controllers\Api\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Comment;
use IQuery;

class CommentController extends Controller
{
	// 全部收藏信息
    public function index(Request $request)
    {
    	$datas = Comment::join('products','comments.product_id','=','products.id')
            ->where('comments.user_id', '=', $request->user_id)
            ->orderBy('comments.created_at','desc')
            ->select('comments.*',
                'products.thumb as product_thumb',
                'user.img as user_img','user.name as user_name'
            )->get();
    	return response()->json($datas);
    }

    // 新增保存
    public function store(Request $request)
    {
        return $this->storeOrUpdate($request);
    }

    // 编辑保存
    public function update(Request $request, $id)
    {
        return $this->storeOrUpdate($request, $id);
    }

    // 新建、编辑 保存方法
    private function storeOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
            'content' => 'required|max:2000',
            'product_id' => 'required',
            'level'=>'required'
        ]);

        if ($id == -1) {
            $model = new Comment;
        } else {
            $model = Comment::find($id);
        }

        $model->content = $request->content;
        $model->product_id = $request->product_id;
        $model->level = $request->level;
        $model->user_id = $request->user_id;
        // $arr = ['content', 'product_id', 'level', 'user_id'];
        // $model->setRawAttributes($request->only($arr));
        $res = IQuery::uploads($request, 'img', true);
        $model->img = $res['ps'];
        $model->thumb = $res['ts'];
        
        if (!$model->save()) return 0;
        if ($id != -1) $model->id = $id;
        return $model->id;
    }
}
