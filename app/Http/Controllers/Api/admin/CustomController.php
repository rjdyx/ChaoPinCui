<?php
/**
 * controller: Custom
 * autoer: guosenlin
 * date: 2017/09/15
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Custom;
use IQuery;

class CustomController extends Controller
{
	// 分页信息
    public function index(Request $request)
    {
    	$datas = Custom::orderBy('created_at','desc');
        $datas = IQuery::ofText($datas,$request->query_text, 'custom');
        $datas = $datas->paginate(config('app.page'));
    	return response()->json($datas);
    }

    // 查看
    public function show($id)
    {
    	return Custom::find($id);
    }

    // 单条删除
    public function destroy($id)
    {
    	if (Custom::destroy($id)) {
            IQuery::ofLog('custom', 4, 0);
            return $id;
        }
        IQuery::ofLog('custom', 4, 1);
    	return 0;
    }

    // 编辑
    public function edit($id)
    {
    	return Custom::find($id);
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
            'content' => 'required|max:2000',
            'sort' => 'nullable|max:10'
        ]);

        if ($id == -1) {
        	$model = new Custom;
        } else {
        	$model = Custom::find($id);
        }

        $arr = ['name', 'content', 'product_id', 'sort'];
        $model->setRawAttributes($request->only($arr));

        if (!$model->save()) {
            IQuery::logNewOrEdit($id, 'custom', 1);
            return 0;
        }
        if ($id != -1) $model->id = $id;
        IQuery::logNewOrEdit($id, 'custom', 0);
        return $model->id;
    }
}
