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
        $user = $request->user_id;
        return response()->json($user);
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
            // 'name' => ['required','max:30',
            //     Rule::unique('users')->ignore($id)->where(function($query) use ($id) {
            //         $query->whereNull('deleted_at');
            //     })
            // ],
            // 'email' => ['required','max:50',
            //     Rule::unique('users')->ignore($id)->where(function($query) use ($id) {
            //         $query->whereNull('deleted_at');
            //     })
            // ],
            // 'phone' => ['required','max:20',
            //     Rule::unique('users')->ignore($id)->where(function($query) use ($id) {
            //         $query->whereNull('deleted_at');
            //     })
            // ],
            'sex' => 'required',
            'age' => 'nullable',
            'real_name' => 'nullable|max:30',
            'password' => 'nullable|max:100',
            'address' => 'nullable|max:100'
        ]);
        $model = User::find($id);
        if ($this->unquired($request,'name', $id)) return 101;
        if ($this->unquired($request,'email', $id)) return 102;
        if ($this->unquired($request,'phone', $id)) return 103;
        $arr = ['name','real_name','sex','age','email','phone','address','img'];
        $model->setRawAttributes($request->only($arr));
        $model->type = 0;
        if ($request->password) $model->password = bcrypt($request->password);
        
        if ($model->save()) return $id;
        return 0;
    }

    //上传图片
    public function uploadImg(Request $request)
    {
        return IQuery::uploads($request, 'img');
    }

    public function unquired($request, $filed, $id)
    {
        $res = User::where($filed, $request->$filed)
                ->where('id','!=',$id)
                ->first();
        if (isset($res->id)) return true;
        return false;
    }
}
