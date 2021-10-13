<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

/**
 * Login Controller
 */
class LoginController extends Controller
{
    /**
     * login page.
     */
    public function index()
    {
        return view('login.login');
    }

    /**
     * login function
     */
    public function doLogin(Request $request)
    {
        return response()->redirectTo('/')->cookie('_cyouho', 'osdijgfoij', 60);
    }

    public function doLogout()
    {
        $cookie = Cookie::forget('_cyouho');
        return response()->redirectTo('/')->cookie($cookie);
    }
}
