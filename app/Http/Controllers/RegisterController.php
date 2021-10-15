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
    private $_message = [];

    public function __construct()
    {
        $this->_message = config('message');
    }

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
        $userId = $test->getUserId($email);

        // 如果没有user ID就生成新的ID
        if (!$userId) {
            $cookie = $test->RegisterSet($email, $password);
        } else {
            return view('register.register', ['errMSG' => $this->_message['error_message']['register']['existed_user']]);
        }
        //dd($request->input('register_email'));
        return response()->redirectTo('/')->cookie('_cyouho', $cookie, 60);
    }
}
