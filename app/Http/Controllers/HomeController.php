<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\PhoneInfo;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    //获取Openid
    public function getOpenid(Request $request)
    {
        $appid = 'wx64f95ab001bb8dd2';
        $secret = '9697804b07c0596aee40c7f35e327d19';
        $grant_type = 'authorization_code';
        $js_code = $request->js_code;
        $post_data = array();
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$js_code.'&grant_type='.$grant_type;
        $postdata = http_build_query($post_data);  
        $options = array(  
            'http' => array(  
              'method' => 'GET',  
              // 'header' => 'Content-type:application/x-www-form-urlencoded',
              'header' => 'Content-type:application/json',  
              'content' => $postdata,  
              'timeout' => 15 * 60 // 超时时间（单位:s）  
            )  
        );  
        $context = stream_context_create($options);  
        $result = file_get_contents($url, false, $context);  
        return response()->json(json_decode($result));
    }

    public function phone (Request $request)
    {
        $phone = $request->phone;
        $appid = '1400043738';
        $appkey = 'd212e754c220cd5833a3bcb3f34a4806';
        $rand = rand(1000,9999);
        $time = time();
        $sig = hash("sha256",'appkey='.$appkey.'&random='.$rand.'&time='.$time.'&mobile='.$phone);
        $url = 'https://yun.tim.qq.com/v5/tlssmssvr/sendsms?sdkappid='.$appid.'&random='.$rand;

        $data = [
            "tel"=>[
                "nationcode"=>"86",
                "mobile"=> $phone
            ], 
            "type"=> 0,
            "msg"=> "你的验证码是".$rand,
            "sig"=> $sig,
            "time"=> $time,
            "extend"=> "", 
            "ext"=> ""
        ];
        return $this->curlPost($url,  json_encode($data));
    }

    // 短信验证码测试
    public function phone2(Request $request){  
        $phone = 13632214480;
        $key = '21484cb6e2b39';
        $secret = 'febbc128b60e6600222b5d1261df3020';
        $code =rand(1000,9999);  
        // $user = new User;
        // return $user->notify(new PhoneInfo($phone));
        // return $code;
        $data = [
            'appkey'=>$key,
            'phone'=>$phone,
            'zone'=>'86',
            'code'=>$code
        ];
        // setcookie('code',$code,time()+600);  
        //把URL地址改成你自己就好了，把手机号码和信息模板套进去就行  
        $url ='https://webapi.sms.mob.com/sms/verify';
        //$url='http://api.sms.cn/sms/?ac=send&uid=haoyunyun&pwd=ccd843e373206a246826181ab48ed1ee&template=384859&mobile='.$iphone.'&content={"code":"'.$code.'"}';   
        return $this->curlPost($url, $data);                
     }  
    /*curlpost传值*/  
    public function curlPost($api, $data, $timeout = 30){    
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $api);
        // 以返回的形式接收信息
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        // 设置为POST方式
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        // 不验证https证书
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            'Accept: application/json',
        ) ); 
        // 发送数据
        $response = curl_exec( $ch );
        // 不要忘记释放资源
        curl_close( $ch );
        return $response;  
    } 
}
