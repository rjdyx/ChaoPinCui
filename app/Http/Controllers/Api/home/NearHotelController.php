<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use IQuery;

class NearHotelController extends Controller
{
	public function getNearHotelData(Request $request) {
		$page = $request->page;
		$round = 1000;
		$weft = $request->weft;  //纬度
		$meridian = $request->meridian;  //经度
		$infos = IQuery::redisGet('near_hotel_info_'.$weft.$meridian.$page);
		if (!isset($infos)) {
			$url = "http://apis.map.qq.com/ws/place/v1/search?keyword=%E9%85%92%E5%BA%97&boundary=nearby($weft,$meridian,$round)&orderby=_distance&key=5ZZBZ-5Q363-U3K3I-YDD5M-R4EAO-NBBG4&page_index=$page";
			$infos = file_get_contents($url);
			IQuery::redisSet('near_hotel_info_'.$weft.$meridian.$page, $infos);
		}
		return $infos;
	}
}