<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkLogin
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
        if(!Auth::check()) {
            dd($request->getRequestUri());
            session()->put('return_url', $request->getRequestUri());
            return redirect()->route('sessions.create')->with('danger', '您尚未登录，禁止操作');
        }
        return $next($request);
    }
}
