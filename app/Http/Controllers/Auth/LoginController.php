<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use IQuery;
use App\Model\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $loginName = 'user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'login', 'resetPassword');
    }

    // 重置密码
    public function resetPassword(Request $request)
    {
        $user_id = $request->user_id;
        $orin_pass = $request->orin_pass;
        $now_pass = $request->now_pass;
        $now_pass_rep = $request->now_pass_rep;
        if (empty($user_id) || empty($orin_pass) || empty($now_pass) || empty($now_pass_rep)) return 100; // 参数错误

        if ($now_pass_rep != $now_pass) return 101; // 两次密码不一致
        $user = User::find($user_id);
        $credentials = ['name'=>$user->name,'password'=>$now_pass];
        if (!$this->guard()->attempt($credentials)) return 102; //原始密码错误

        //重设密码
        $user->password = bcrypt($now_pass);
        if ($user->save()) return 200; //重置成功
        return 500; // 重置失败
    }   

    // 登录
    public function Login(Request $request)
    {
        $this->validateLogin($request);//字段验证
        $credentials = $this->credentials($request);//判断登陆方式（用户名、邮箱、手机号）
        if ($this->guard()->attempt($credentials, $request->has('remember'))) { //登陆
            IQuery::ofLog('login', 0, 0);
            return $this->sendLoginResponse($request); //登陆成功
        }
        $this->incrementLoginAttempts($request); //登陆失败
        return 500;
    }

    //字段验证
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginName => 'required|min:4', 'password' => 'required|min:4'
        ]);
    }

    //获取登录字段
    public function credentials(Request $request)
    {
        $loginName = $this->loginName;
        $name = $request->$loginName;
        $field = filter_var($name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        if($this->isMobile($name)) {
            $field = 'phone';
        } 
        return [
            $field => $name,
            'password' => $request->password
        ];
    }

    //登录成功
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $time = date("y-m-d h:i:s",time());
        Session::put('time',$time);
        return 200;
    }

    //登出
    public function logout()
    {
        IQuery::ofLog('logout', 1, 0);
        $this->guard()->logout();
        return 200;
    }

    //验证手机
    public function isMobile($mobile) 
    {
        if(preg_match("/^1[34578]\d{9}$/", $mobile)) return true;
        return false;
    }
}
