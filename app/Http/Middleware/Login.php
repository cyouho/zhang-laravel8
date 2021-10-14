<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Login
{
    /**
     * Handle an incoming request.
     * Check it if Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        request()->cookie('_cyouho') ? view()->share('isLogin', true) : view()->share('isLogin', false);

        return $next($request);
    }
}
