<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     * 不需要被Laravel加密的cookies
     * 需要明文传递的cookies
     * @var array
     */
    protected $except = [
        '_cyouho',
        '_zhangfan'
    ];
}
