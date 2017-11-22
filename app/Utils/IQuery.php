<?php 
/**
 * desc: 工具类
 * autoer: guosenlin
 * date: 2017/09/14
 */
namespace App\Utils;

use Illuminate\Support\Facades\Auth;
use App\Model\Log;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redis;

class IQuery{

    // 单张图片上传
	public function upload($request, $name='img',$isThumb = false)
	{
        $filename = $name.'s';
        $pic=array();
        if ($request->hasFile($filename)) {
            $file = $request->file($filename);
            $path = config('app.image_path').'/';
            $Extension = $file->getClientOriginalExtension();
            $filename = 'SZGC_'.time().'.'. $Extension;
            $check = $file->move($path, $filename);
            $filePath = $path.$filename; //原图路径加名称
            $pic['p']= $filePath;//原图
            if ($isThumb) {
                $newfilePath = $path.'SZGC_S_'.time().'.'. $Extension;//缩略图路径名称
                $this->img_create_small($filePath,config('app.thumb_width'),config('app.thumb_height'),$newfilePath);  //生成缩略图
                $pic['t']= $newfilePath;//缩略图
            }
            $this->destroyPic($request, $name);
        } else {
            if (isset($filename)) {
                if ($request->$filename != 'del') {
                    $pic['p']= $request->$name;//原图
                    $pic['t']= $request->thumb;//缩略图
                } else {
                    $this->destroyPic($request, $name);
                    $pic['p']= '';
                    $pic['t']= '';
                }
            } else {
                $pic['p']= $request->$name;//原图
                $pic['t']= $request->thumb;//缩略图
            }
        }
        return $pic;//返回原图 缩略图 的路径 数组
	}

    // 多图片异步上传
    public function uploads($request, $filenames='imgs', $isThumb=false)
    {         
        $res = ['ps'=>'', 'ts'=>''];
        $files = $request->file($filenames);
        if (!empty($files) && count($files) && is_array($files)) {
            foreach ($files as $file) {
                $data = $this->uploadOrs($file, $minState, $isThumb);
                $imgs[] = $data['p'];
                if ($isThumb) {
                    $thumbs[] = $data['t'];
                }
            }
            $res['ps'] = implode('|', $imgs);
            if ($isThumb) $res['ts'] = implode('|', $thumbs);
        }
        return $res;
    }

	//生成缩略图
    public function img_create_small($big_img, $width, $height, $small_img) {  //原始大图地址，缩略图宽度，高度，缩略图地址
        $imgage = getimagesize($big_img); //得到原始大图片
        switch ($imgage[2]) { // 图像类型判断
        	case 1:
        	$im = imagecreatefromgif($big_img);
        	break;
        	case 2:
        	$im = imagecreatefromjpeg($big_img);
        	break;
        	case 3:
        	$im = imagecreatefrompng($big_img);
        	break;
        }
        $src_W = $imgage[0]; //获取大图片宽度
        $src_H = $imgage[1]; //获取大图片高度
        $tn = imagecreatetruecolor($width, $height); //创建缩略图
        imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $src_W, $src_H); //复制图像并改变大小
        imagejpeg($tn, $small_img); //输出图像
    }

    // 单图片上传
    public function singleImg($request, $img) {
        $imgs = $img.'s';
        if ($request->hasFile($imgs)) {
            $file = $request->file($imgs);
            $path = config('app.image_path').'/';
            $Extension = $file->getClientOriginalExtension();
            $filename = 'SZGC_'.rand(1000,9999).time().'.'. $Extension;
            $check = $file->move($path, $filename);
            $filePath = $path.$filename; //原图路径加名称
            $pic= $filePath;//原图
            $this->delImg($request->$img);
            return $pic;
        } else {
            if ($request->$img != '') {
                if ($request->$imgs == 'del') {
                    $this->delImg($request->$img);
                    return '';
                }
                return $request->$img;
            } else {
                return '';
            }
        }
    }

    // 删除图片
    public function destroyPic($request, $name)
    {
    	if (!empty($request->$name)) {
            $img = str_replace("\\","/",public_path().'/'.($request->$name));
            $thumb = str_replace("\\","/",public_path().'/'.($request->thumb));
            if (is_file($img)) unlink($img);
            if (is_file($thumb)) unlink($thumb);
        }
    }

     //删除图片
    public function delImg($file) {
        if ($file != null && $file != '') {
            $pic = str_replace("\\","/",public_path().'/'.($file));
            if (is_file($pic)) unlink($pic);
        }
    }

    //加入文本查询
    public function ofText(&$query, $val, $m, $text_params=['name'])
    {
        if (isset($val)) {
            $texts =  explode(' ',$val);
            $query = $query->where(function ($query) use ($text_params, $texts){
                foreach($text_params as $param){
                    $query->orWhere(function($query) use ($param, $texts){
                        foreach($texts as $text){
                            $query->where($param,'like', '%'.$text.'%');
                        }
                    });
                }
            });
            $this->ofLog($m, 6, 0);
        }
        return $query;
    }

    // 新增或编辑操作日志存储
    public function logNewOrEdit ($id, $m, $s) {
        if ($id != -1) {
            $this->ofLog($m, 3, $s);
        } else {
            $this->ofLog($m, 2, $s);
        }
    }

    // 日志操作$m为操作模块，$c为操作内容，$s为操作状态
    public function ofLog($m, $c, $s) {
        $comment = Lang::get('log.comment');
        $model = Lang::get('log.model');
        $state = Lang::get('log.state');
        $log = new Log;
        $log->name = $model[$m];
        $log->operate = $comment[$c].$state[$s];
        $log->ip = $_SERVER["REMOTE_ADDR"];
        $log->user_id = Auth::user()->id;
        $log->save();
    }

    // 前端图片存储
    public function setImg($request, $name, $con, $pre) {
        if ($request->hasFile($name)) {
            $file = $request->file($name);
            $path = $con;
            $Extension = $file->getClientOriginalExtension();
            $filename = $pre.rand(1000,9999).time().'.'. $Extension;
            $check = $file->move($path, $filename);
            $filePath = $path.$filename; //原图路径加名称
            $pic= $filePath;//原图
            return $pic;
        }
    }

    // 删除多图片
    public function delMosImg($imgs) {
        $imgArr = explode(',', $imgs);
        foreach($imgArr as $img) {
            $img = str_replace("\\","/",public_path().'/'.($img));
            if (is_file($img)) unlink($img);
        }
    }

    /*
     * 获取redis中get值
     * $key键值
     */
    public function redisGet($key) {
        $value = Redis::get(config('app.redis_pre').'_'.$key);
        $value_serl = @unserialize($value);
        if(is_object($value_serl)||is_array($value_serl)){
            return $value_serl;
        }
        return $value;
    }

    /*
     * 设置redis键值
     * $key键,$val值
     */
    public function redisSet($key, $val) {
        if(is_object($val)||is_array($val)){
            $val = serialize($val);
        }
        Redis::setex(config('app.redis_pre').'_'.$key, config('app.redis_time'), $val);
    }

    /*
     * 获取微信用户头像
     * $openid 根据已有openid
     */
    public function getWxPic($openid) {
        $appid = 'wx64f95ab001bb8dd2'; // 小程序appid
        $secret = '9697804b07c0596aee40c7f35e327d19'; //密匙
        $grant_type = 'client_credential'; //固定值
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type='.$grant_type.'&appid='.$appid.'&secret='.$secret;
        $token = $this->getJson($url);
        $access_token = $token['access_token'];
        $get_user_info_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $userInfo = $this->getJson($get_user_info_url);
        return $userInfo;
    }

    /*
     * 转化数据样式
     * url微信地址
     */
    public function getJson($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

}