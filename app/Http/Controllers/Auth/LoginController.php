<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use IQuery;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

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

    // 登录
    public function Login(Request $request)
    {
        $this->validateLogin($request);//字段验证
        $request->password=IQuery::passDecrypt($request->password, env('PASS_KEY'));
        return $request->password;
        $credentials = $this->credentials($request);//判断登陆方式（用户名、邮箱、手机号）
        if ($this->guard()->attempt($credentials, $request->has('remember'))) { //登陆
            IQuery::ofLog('login', 0, 0);
            return $this->sendLoginResponse($request); //登陆成功
        }
        $this->incrementLoginAttempts($request); //登陆失败
        return response()->json(['res' => 0, 'status'=> 500]);
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
        $time = date("Y-m-d H:i:s",time());
        Session::put('time',$time);
        return response()->json(['res' => Auth::user()->type, 'status'=> 200]);
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
