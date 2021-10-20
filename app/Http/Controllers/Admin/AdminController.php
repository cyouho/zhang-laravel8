<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;

class AdminController extends Controller
{
    /**
     * 显示 admin 的登录页面
     */
    public function index()
    {
        return view('admin.admin_login');
    }

    public function doLogin(Request $request)
    {
        $admin = new Admin();
        $email = $request->input('login_email');
        $password = $request->input('login_pwd');
        $userId = $admin->getUserId($email);
    }
}
