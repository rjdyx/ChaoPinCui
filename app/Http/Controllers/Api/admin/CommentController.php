<?php
/**
 * controller: Comment
 * autoer: guosenlin
 * date: 2017/09/15
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Comment;
use IQuery;

class TurnController extends Controller
{
	// 分页信息
    public function index(Request $request)
    {
    	$datas = Comment::paginate(config('app.page'));
    	return response()->json($datas);
    }

    // 查看
    public function show($id)
    {
    	return Comment::find($id);
    }

    // 单条删除
    public function destroy($id)
    {
    	$model = Comment::find($id);
    	if ($model->destroy()) return $id;
    	return 0;
    }

    // 编辑
    public function edit($id)
    {
    	return Comment::find($id);
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
            'content' => 'required|text|max:2000',
            'product_id' => 'required|exists:products',
            'level' => 'required',
            'url' => 'nullable|max:100',
        ]);

        if ($id == -1) {
        	$model = new Comment;
        } else {
        	$model = Comment::find($id);
        }

        $arr = ['name', 'content', 'product_id', 'sort', 'desc'];
        $model->setRawAttributes($request->only($arr));
        $res = IQuery::uploads($request, 'img', true);
        $model->img = $res['ps'];
        $model->thumb = $res['ts'];
        
        if ($model->save()) return 1;
        return 0;
    }
}
