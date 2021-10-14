<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;

/**
 * Register Controller
 */
class RegisterController extends Controller
{
    /**
     * register page.
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
        $test = new User();
        $email = $request->input('register_email');
        $password = $request->input('register_pwd');
        $userId = $test->get($email);

        if (!$userId) {
            $cookie = $test->RegisterSet($email, $password);
        }
        //dd($request->input('register_email'));
        return response()->redirectTo('/')->cookie('_cyouho', $cookie, 60);
    }
}
