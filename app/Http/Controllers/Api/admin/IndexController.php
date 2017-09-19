<?php
/**
 * controller: Index
 * autoer: guosenlin
 * date: 2017/09/18
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\System;
use App\Model\User;
use IQuery;

class IndexController extends Controller
{
	// 首页信息
    public function index(Request $request)
    {
        $user = Auth::user();
    	$system = System::first();
    	return response()->json(['user'=>$user, 'system'=>$system]);
    }

    // 编辑保存
    public function update(Request $request, $id)
    {
    	return $this->storeOrUpdate($request, $id);
    }

    // 保存方法
    private function storeOrUpdate($request, $id)
    {
        $this->validate($request, [
            'name' => ['required','max:30',
                Rule::unique('users')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ],
            'email' => ['required','max:50',
                Rule::unique('users')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ],
            'phone' => ['required','max:20',
                Rule::unique('users')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ],
            'sex' => 'required',
            'age' => 'nullable|datetime',
            'real_name' => 'nullable|max:30',
            'password' => 'nullable|max:100',
            'address' => 'nullable|max:100'
        ]);

        $model = User::find($id);
        $arr = ['name', 'real_name', 'sex', 'age', 'email', 'phone', 'address', 'password'];

        $model->setRawAttributes($request->only($arr));
        $model->img = IQuery::upload($request,'img')['p'];

        if ($model->save()) return 1;
        return 0;
    }
}
