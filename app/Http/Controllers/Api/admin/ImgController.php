<?php
/**
 * controller: Img
 * autoer: guosenlin
 * date: 2017/09/15
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Img;
use IQuery;

class ImgController extends Controller
{
	// 分页信息
    public function index(Request $request)
    {
    	$datas = Img::orderBy('created_at','desc')->where('product_id',$request->id);
        $datas = IQuery::ofText($datas, $request->query_text, 'img');
        $datas = $datas->paginate(config('app.page'));
    	return response()->json($datas);
    }

    // 查看
    public function show($id)
    {
    	return Img::find($id);
    }

    // 单条删除
    public function destroy($id)
    {
    	if (Img::destroy($id)) {
            IQuery::ofLog('img', 4, 0);
            return $id;
        }
        IQuery::ofLog('img', 4, 1);
    	return 0;
    }

    // 编辑
    public function edit($id)
    {
    	return Img::find($id);
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
            'name' => 'required|max:50',
            'desc' => 'nullable|max:255',
            'sort' => 'required|max:10'
        ]);

        if ($id == -1) {
        	$model = new Img;
        } else {
        	$model = Img::find($id);
        }
        $arr = ['name', 'product_id', 'sort', 'desc'];
        $model->setRawAttributes($request->only($arr));
        $res = IQuery::upload($request,'img', true);
        $model->img = $res['p'];
        $model->thumb = $res['t'];

        if (!$model->save()) {
            IQuery::logNewOrEdit($id, 'img', 1);
            return 0;
        }
        if ($id != -1) $model->id = $id;
        IQuery::logNewOrEdit($id, 'img', 0);
        return [
            'id'=>$model->id,
            'img'=>$model->img
        ];
    }
}
