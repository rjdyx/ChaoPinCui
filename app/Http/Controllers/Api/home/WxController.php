<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use App\System;
use IQuery;
use Redirect;
use Session;

class WxController extends Controller
{
	use AuthenticatesUsers;

    /**
     *  100 : 已登录
     *  300 ：已被绑定
     *  400 : 账号或密码错误
     *  500 : 服务器错误
     *  200 ：登录并绑定成功
     *  404 ：未登录
     */
    
    // 微信号绑定判断
    public function wxCheck(Request $request)
    {
        if (empty($request->openid)) return 500;
        $user = User::where('openid', $request->openid)->first();
        if (!isset($user->id) && empty($user->id)) return 400;
        return $user;
    }
    
    //微信绑定账户
    public function bindWeiXin(Request $request)
    {
        /****** 1.登录状态 ******/
        if (Auth::user()) return 100;

        $user = $this->credentials($request);
        $filed = $user[1]['filed'];

        /****** 2.微信号是否被绑定 ******/
        $model = User::where('openid',$request->openid)->where($filed,'!=',$user[0][$filed])->first();
        if (!empty($model->id)) return 300;

        /****** 3.用户密码验证 ******/
        if (!$this->guard()->attempt($user[0])) return 400;

        /****** 4.绑定登录 ******/
        return $this->login($request, $filed, $user[0][$filed]);
    }

    // 微信直接登陆
    public function wxLogin(Request $request) {
        $user = User::where('wxopenid','=',$request->openid)->first();
        if ($user != null) {
            $user->openid = $request->openid;
            if (!$user->save()) return 500;
            return $user;
        } else {
            $data['name'] = $this->createRandomStr(10);
            $data['type'] = 0;
            $data['real_name'] = $request->real_name; 
            $data['sex'] = $request->sex;
            $data['openid'] = $request->openid;
            $data['wxopenid'] = $request->openid;
            $data['password'] = bcrypt('000000');
            $result = User::create($data);
            return $result;
        }
    }

    //  登录、绑定
    public function login($request, $filed, $value)
    {   
        $model = User::where($filed, $value)->first();
        $model->openid = $request->openid;
        if (!$model->save()) return 500;
        return $model;
    }

    //微信号快速注册
    public function bindWeiXinUserRegister(Request $request)
    {
        if ($request->password != $request->repassword) return 100;
        if ($this->userCheckUnique('name', $request->name)) return 101;
        if ($this->userCheckUnique('email', $request->email)) return 102;
        if ($this->userCheckUnique('phone', $request->phone)) return 103;
        if ($this->userCheckUnique('openid', $request->openid)) return 104;
        $data['openid'] = $request->openid;
        $data['wxopenid'] = $request->openid;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['type'] = 0;
        $data['sex'] = 0;
        $data['password'] = bcrypt($request->password);
        $result = User::create($data);
        //注册成功 自动登录
        if (!$result) return 500;
        // auth()->login($result);//自动登录;
        return $result;
        // return 200;
    }   

    public function userCheckUnique($file, $value)
    {
        $user = User::where($file, $value)->first();
        if (isset($user->id)) return true;
        return false;
    }

    //微信解除绑定
    public function bindWeiXinRelieve(Request $request)
    {
    	// if (!Auth::user()) return 404;  // 未登录
    	$user = User::find($request->user_id);
    	$user->openid = null;
    	if (!$user->save()) return 1;
    	// $this->guard()->logout();
    	return 0;
    }

    // 唯一随机字符串
    public function randOnlyEmail()
    {
    	$rand = $this->Noncestr();//随机字符串
    	$email = $rand.'@qq.com';
		$user = User::where('email',$email)->first();
		while (isset($user->id)) {
			$rand = $this->Noncestr();//随机字符串
    		$email = $rand.'@qq.com';
			$user = User::where('email',$email)->first();
		}
		return $rand;
    }
    // 随机字符串生成
    public function createRandomStr($length){ 
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//62个字符 
        $strlen = 62; 
        while($length > $strlen) {
            $str .= $str; 
            $strlen += 62; 
        } 
        $str = str_shuffle($str); 
        return substr($str,0,$length); 
    } 

    //获取登录字段
    public function credentials(Request $request)
    {
        $login = $request->user;
        $field1 = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        if($this->isMobile($login)) {
            $field='phone';
        } else {
            $field=$field1;
        }
        return [
            [$field => $login,'password' => $request->password],
            ['filed'=>$field]
        ];
    }

    //验证手机
    public function isMobile($mobile) 
    {
        if(preg_match("/^1[34578]\d{9}$/", $mobile) && strlen($mobile)== 11){
            return true;
        } else {
            return false;
        }
    }

    //产生随机字符串，不长于10位
    public function Noncestr( $length = 10 ) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        }  
        return $str;
    }

}