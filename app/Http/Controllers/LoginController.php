<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Login Controller
 */
class LoginController extends Controller
{
    /**
     * return login page.
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
        dd($request->post('login_email'));
    }
}
