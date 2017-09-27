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

    // 短信验证码测试
    public function phone(Request $request){  
        $phone = $request->phone;
        $key = '21484cb6e2b39';
        $secret = 'febbc128b60e6600222b5d1261df3020';
        $code=rand(1000,9999);  
        $user = new User;
        $user->notify(new PhoneInfo($phone));
        return $code;
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
        $method='POST';  
        return $this->curlPost($url, $data,$method);                
     }  
    /*curlpost传值*/  
    public function curlPost($url,$data,$method){    
       $ch = curl_init();   //1.初始化    
       curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址    
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//3.请求方式    
       //4.参数如下    
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//https    
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
       curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');//模拟浏览器    
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    
       curl_setopt($ch, CURLOPT_AUTOREFERER, 1);    
       curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));//gzip解压内容    
       curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');    
       if($method=="POST"){//5.post方式的时候添加数据    
           curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
       }    
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
       $tmpInfo = curl_exec($ch);//6.执行    
       if (curl_errno($ch)) {//7.如果出错    
           return curl_error($ch);    
       }    
       curl_close($ch);//8.关闭    
       return $tmpInfo;    
    } 
}
