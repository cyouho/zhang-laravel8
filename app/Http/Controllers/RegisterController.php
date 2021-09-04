<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Register Controller
 */
class RegisterController extends Controller
{
    /**
     * return register page.
     */
    public function index()
    {
        return view('register.register');
    }

    /**
     * register function
     */
    public function doRegister(Request $request)
    {
        dd($request->post());
    }
}
