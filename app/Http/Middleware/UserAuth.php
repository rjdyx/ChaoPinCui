<?php
/**
 * auther:郭森林
 * date: 2017/09/15
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAuth
{
    private $res = [
        '401' => 'Not logged in or authorized', //未授权
        '403' => 'No access rights', // 无访问权限
    ];

    // 用户登录及权限 中间件
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::user()) {
            return response()->json($this->res['401'], 401);
        }

        if ($role == 'admin' && Auth::user()->type == 0) {
            return response()->json($this->res['403'], 403);
        }

        return $next($request);
    }
}
