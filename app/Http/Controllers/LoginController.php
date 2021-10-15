<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

/**
 * Login Controller
 */
class LoginController extends Controller
{
    private $_message = [];

    public function __construct()
    {
        $this->_message = config('message');
    }

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
        $user = new User();
        $email = $request->input('login_email');
        $password = $request->input('login_pwd');
        $userId = $user->getUserId($email);

        if (!$userId) {
            return view('login.login', ['errMSG' => [
                'id' => $this->_message['error_message']['login']['not_exist_user_id'],
            ]]);
        } else if (!$user->checkUserPwd($password, $email)) {
            return view('login.login', ['errMSG' => [
                'pwd' => $this->_message['error_message']['login']['password_error']
            ]]);
        }

        $cookie = $user->getSeesion($email);
        return response()->redirectTo('/')->cookie('_cyouho', $cookie, 60);
    }

    /**
     * Logout function
     * 
     */
    public function doLogout()
    {
        $cookie = Cookie::forget('_cyouho');
        return response()->redirectTo('/')->cookie($cookie);
    }
}
