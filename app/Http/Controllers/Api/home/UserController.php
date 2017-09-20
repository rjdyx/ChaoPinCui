<?php
/**
 * controller: User
 * autoer: guosenlin
 * date: 2017/09/18
*/
namespace App\Http\Controllers\Api\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\User;
use IQuery;

class UserController extends Controller
{
	// 用户信息
    public function index(Request $request)
    {
        return response()->json(Auth::user());
    }

    // 编辑
    public function edit($id)
    {
    	return User::find($id);
    }

    // 编辑保存
    public function update(Request $request, $id)
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
        $arr = ['name','real_name','sex','age','email','phone','address'];
        $model->setRawAttributes($request->only($arr));
        $model->img = IQuery::upload($request,'img')['p'];
        $model->type = 0;
        if ($request->password) $model->password = bcrypt($request->password);
        
        if ($model->save()) return $id;
        return 0;
    }

}
