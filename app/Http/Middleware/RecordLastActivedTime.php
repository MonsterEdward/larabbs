<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class RecordLastActivedTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // https://laravel-china.org/courses/laravel-intermediate-training/5.5/user-last-logon-time/682
        // 如果是登录用户
        if(Auth::check()) {
            // 记录最后登录时间
            Auth::user()->recordLastActivedAt();
        }
        return $next($request);
    }
}
