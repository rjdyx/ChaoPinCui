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

    public function setUpdate(Request $request) {
        $this->validate($request, [
            'sex' => 'required',
            'age' => 'nullable',
            'real_name' => 'nullable|max:30',
            'password' => 'nullable|max:100',
            'address' => 'nullable|max:100'
        ]);
        $id = $request->id;
        $model = User::find($id);
        $type = $model->type;
        if ($this->unquired($request,'name', $id)) return 101;
        if ($this->unquired($request,'email', $id)) return 102;
        if ($this->unquired($request,'phone', $id)) return 103;
        $arr = ['name','real_name','sex','age','email','phone','address','img'];
        $model->setRawAttributes($request->only($arr));
        if ($type!=1) {
            $model->type = 0;
        }
        if ($request->password) $model->password = bcrypt($request->password);
        $model->img = IQuery::singleImg($request,'img');
        if ($model->save()) return $id;
        return 0;
    }

    public function unquired($request, $filed, $id)
    {
        $res = User::where($filed, $request->$filed)
                ->where('id','!=',$id)
                ->first();
        if (isset($res->id)) return true;
        return false;
    }

    // 重置密码
    public function resetPassword(Request $request)
    {
        $user_id = $request->user_id;
        $orin_pass = $request->orin_pass;
        $now_pass = $request->now_pass;
        if (empty($user_id)) return 100; // 参数错误

        $user = User::find($user_id);
        if (!\Hash::check($orin_pass,$user->password)) {
           return 102;
        }
        
        //重设密码
        $user->password = bcrypt($now_pass);
        if ($user->save()) return 200; //重置成功
        return 500; // 重置失败
    }   
}
