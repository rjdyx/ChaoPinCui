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

class CommentController extends Controller
{
	// 分页信息
    public function index(Request $request)
    {
        $id = $request->id;
    	$datas = Comment::join('users','comments.user_id','=','users.id')
                ->where('comments.product_id','=',$id)
                ->orderBy('created_at','desc')
                ->select('comments.*','users.name as user_name');
        $datas = IQuery::ofText($datas, $request->query_text, 'comment', ['comments.content']);
        $datas = $datas->paginate(config('app.page'));
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
        $comment = Comment::find($id);
        IQuery::delMosImg($comment->img);
    	if (Comment::destroy($id)) {
            IQuery::ofLog('comment', 4, 0);
            return $id;
        }
        IQuery::ofLog('comment', 4, 1);
    	return 0;
    }

    // 编辑
    public function edit($id)
    {
    	return Comment::find($id);
    }
}
