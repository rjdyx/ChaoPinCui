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
            ->join('users','comments.user_id','=','users.id')
            ->where('comments.user_id', '=', $request->user_id)
            ->orderBy('comments.created_at','desc')
            ->select('comments.*',
                'products.thumb as product_thumb','products.name as product_name',
                'users.img as user_img','users.name as user_name'
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
    public function storeOrUpdate(Request $request, $id = -1)
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
        $isUserName = $request->isUserName;
        $arr = ['content', 'product_id', 'level', 'user_id', 'img'];
        $model->setRawAttributes($request->only($arr));
        if ($isUserName == 1) {
            $model->anony = '游客'.time().rand(0,1000);
        }
        
        if (!$model->save()) return 0;
        if ($id != -1) $model->id = $id;
        return $model->id;
    }

    //上传图片
    public function uploadImg(Request $request)
    {
        $img = 'img';
        $pic = IQuery::setImg($request,$img,'comment/','COM_');
        return $pic;
    }
}
