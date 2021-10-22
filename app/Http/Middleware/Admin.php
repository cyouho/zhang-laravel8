<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $cookie = request()->cookie('_zhangfan');
        if (is_null($cookie)) {
            redirect('/admin')->send();
        }
        return $next($request);
    }
}
