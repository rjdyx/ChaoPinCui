<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\System;
use IQuery;

class SystemController extends Controller
{
	public function index()
	{
		return System::select('name', 'email', 'phone', 'address')->first();
	}
}