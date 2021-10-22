<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{

    private $_message = [];

    public function __construct()
    {
        $this->_message = config('message');
    }

    /**
     * 显示 admin 的登录页面
     */
    public function index()
    {
        return view('admin.login.admin_login');
    }

    public function adminIndex()
    {
        return view('admin.index.admin_index_layer');
    }

    public function doLogin(Request $request)
    {
        $admin = new Admin();
        $email = $request->input('login_email');
        $password = $request->input('login_pwd');
        $adminId = $admin->getAdminId($email);
        $data = [
            'admin_email' => $email,
        ];

        if (!$adminId) {
            return view('admin.login.admin_login', ['errMSG' => [
                'id' => $this->_message['error_message']['login']['not_exist_user_id'],
            ]]);
        } else if (!$admin->checkUserPwd($password, $data)) {
            return view('admin.login.admin_login', ['errMSG' => [
                'pwd' => $this->_message['error_message']['login']['password_error']
            ]]);
        }

        $admin->updateLastLoginTime($email);
        $admin->updateTotalLoginTimes($email);
        $cookie = $admin->getSeesion($email);
        return response()->redirectTo('/adminIndex')->cookie('_zhangfan', $cookie, 60);
    }

    public function doLogout()
    {
        $cookie = Cookie::forget('_zhangfan');
        return response()->redirectTo('/admin')->cookie($cookie);
    }

    public function doRegister(Request $request)
    {
        $admin = new Admin();
        $email = $request->input('login_email');
        $password = $request->input('login_pwd');
        $role = $request->input('role');
        $adminId = $admin->getAdminId($email);

        // 如果没有admin ID就生成新的ID
        if (!$adminId) {
            $cookie = $admin->RegisterSet($email, $password, $role);
        } else {
            return view('admin.index.admin_index_layer', ['errMSG' => $this->_message['error_message']['register']['existed_user']]);
        }
        //dd($request->input('register_email'));
        return response()->redirectTo('/')->cookie('_zhangfan', $cookie, 60);
    }
}
