<?php
/**
 * controller: System
 * autoer: guosenlin
 * date: 2017/09/14
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Log;
use IQuery;

class LogController extends Controller
{
    public function index(Request $request) {
        $datas = Log::join('users','logs.user_id','=','users.id')->whereNull('users.deleted_at')
                ->orderBy('created_at','desc')->select('logs.*','users.name as user_name');
        $datas = IQuery::ofText($datas,$request->query_text,$text_params=['logs.name']);
        $datas = $datas->paginate(config('app.page'));
        return response()->json($datas);
    }

    // 查看
    public function show()
    {
    	return System::first();
    }

    // 编辑
    public function edit()
    {
    	return System::first();
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
    private function storeOrUpdate($request, $id=-1)
    {
    	$this->validate($request, [
            'name' => 'required|max:50',
            'icp' => 'nullable|max:100',
            'copy' => 'nullable|max:100',
            'keywords' => 'nullable|max:255',
            'address' => 'nullable|max:100',
            'email' => 'nullable|max:50',
            'phone' => 'nullable|max:20'
        ]);

        if ($id == -1) {
        	$model = new System;
        } else {
        	$model = System::find($id);
        }

        $arr = ['name','icp','copy','keywords','phone','address','email'];
        $model->setRawAttributes($request->only($arr));
        $model->logo = IQuery::singleImg($request,'logo');

        if (!$model->save()) return 0;
        if ($id != -1) $model->id = $id;
        return $model->id;
    }
}
