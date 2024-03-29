<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
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
    
    //微信绑定账户
    public function bindWeiXin(Request $request)
    {
        /****** 1.登录状态 ******/
        if (Auth::user()) return 100;

        /****** 2.微信号是否被绑定 ******/
        $user = User::where('name',$request->openid)->first();
        if (empty($user->id)) return 300;

        /****** 3.用户密码验证 ******/
        $user = $this->credentials($request);
        if (!$this->guard()->attempt($user)) return 400;

        /****** 4.绑定登录 ******/
        return $this->login($request);
    }

    //  登录、绑定
    public function login($request)
    {   
        $user = User::where('email', $request->email);
        $user->openid = $request->openid;
        if (!$user->save()) return 500;
        auth()->login($user);
        return 200;
    }

    //微信号快速注册
    public function bindWeiXinUserRegister(Request $request)
    {
        $data['openid'] = $request->openid;
        $data['realname'] = $request->nickname;
        $data['img'] = $request->headimgurl;
        $data['sex'] = $request->sex;
        $data['name'] = $this->Noncestr();
        // $data['phone'] = $request->phone;
        $data['email'] = $this->randOnlyEmail();
        $data['password'] = bcrypt('000000');
        $result = User::create($data);
        //注册成功 自动登录
        if ($result) return 500;
        auth()->login($result);//自动登录;
        return 200;
    }   

    //微信解除绑定
    public function bindWeiXinRelieve()
    {
    	if (!Auth::user()) return 404;  // 未登录
    	$user = User::find(Auth::user()->id);
    	$user->openid = null;
    	if (!$user->save()) return 500;
    	$this->guard()->logout();
    	return 200;
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
            $field => $login,
            'password' => $request->pass,
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