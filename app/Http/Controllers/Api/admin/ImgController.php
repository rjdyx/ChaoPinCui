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
    	$datas = Img::paginate(config('app.page'));
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
    	$model = Img::find($id);
    	if ($model->destroy()) return $id;
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
            'product_id' => 'required|exists:products',
            'sort' => 'required|max:10'
        ]);

        if ($id == -1) {
        	$model = new Img;
        } else {
        	$model = Img::find($id);
        }

        $arr = ['name', 'content', 'product_id', 'sort', 'desc'];
        $model->setRawAttributes($request->only($arr));
        $res = IQuery::upload($request,'img');
        $model->img = $res['p'];
        $model->thumb = $res['t'];

        if ($model->save()) return 1;
        return 0;
    }
}
