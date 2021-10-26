<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Utils;

class AdminController extends Controller
{

    /**
     * 向页面输出的所有 message
     * @param array $_message
     */
    private $_message = [];

    /**
     * 管理员角色
     * @param array $_role
     */
    private $_role = [];

    /**
     * session
     */
    private $_session = '';

    /**
     * 将 config 里的 message 语句复制给 $_message
     */
    public function __construct()
    {
        $this->_message = config('message');
        $this->_role = config('admin.role');
        $this->_session = Utils::getAdminCookie();
    }

    /**
     * 显示 admin 的登录页面
     */
    public function index()
    {
        return view('admin.login.admin_login');
    }

    /**
     * 显示 admin 的主页
     * @return mix view
     */
    public function adminIndex()
    {
        $admin = new Admin();
        $lastLoginAt = date('Y-m-d', $admin->getLastLoginTime($this->_session));
        $totalLoginTimes = $admin->getTotalLoginTimes($this->_session);
        $createAt = date('Y-m-d', $admin->getRegisterTime($this->_session));

        return view('admin.index.admin_index_layer', ['adminHomePageData' => [
            'last_login_at'     => $lastLoginAt,     // key: 'last_login_at'
            'total_login_times' => $totalLoginTimes, // key: 'total_login_times'
            'create_at'         => $createAt,        // key: 'create_at'
        ]]);
    }

    /**
     * 显示创建新管理员的页面
     * @return mix view
     */
    public function createAdminIndex()
    {
        return view('admin.create.admin_create_new_layer');
    }

    /**
     * 显示所有管理员的信息页面
     * @return mix view
     */
    public function showAdminInfo()
    {
        $admin = new Admin();
        $result = $admin->getAllAdminInfo();
        $numberOfSuperAdmin = 0;
        $numberOfAdmin = 0;
        $numberOfdevelper = 0;

        // 将 role 的 1,2,3 等数字转换成中文的 超级管理员，管理员，开发者
        foreach ($result as &$value) {
            if ($value['role'] === 1) {
                $numberOfSuperAdmin++;
            } else if ($value['role'] === 2) {
                $numberOfAdmin++;
            } else if ($value['role'] === 3) {
                $numberOfdevelper++;
            }
            $value['role'] = $this->_role[$value['role']];
        }
        unset($value);

        $numberOfTotalAdmins = count($result);
        $totalAdminInfo = [
            'number_of_total_admins' => $numberOfTotalAdmins,
            'number_of_super_admin'  => $numberOfSuperAdmin,
            'number_of_admin'        => $numberOfAdmin,
            'number_of_develper'     => $numberOfdevelper,
        ];

        return view('admin.info.admin_info_layer', [
            'adminInfo' => $result,
            'numberOfTotalAdmin' => $totalAdminInfo,
        ]);
    }

    /**
     * 管理员登录
     * @return string cookie | mix view
     */
    public function doLogin(Request $request)
    {
        $admin = new Admin();
        $email = $request->input('login_email');
        $password = $request->input('login_pwd');
        $data = [
            'admin_email' => $email,
        ];
        $adminId = $admin->getAdminId($data);
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

    /**
     * 管理员退出登录
     * @return mix
     */
    public function doLogout()
    {
        $cookie = Cookie::forget('_zhangfan');
        return response()->redirectTo('/admin')->cookie($cookie);
    }

    /**
     * 管理员注册
     * @return mix view
     */
    public function doRegister(Request $request)
    {
        $admin = new Admin();
        $formData = $request->post();
        $email = $formData['adminEmail'];
        $password = $formData['adminPwd'];
        $role = $formData['adminRole'];
        $data = [
            'admin_email' => $email,
        ];
        $adminId = $admin->getAdminId($data);

        // 如果没有admin ID就生成新的ID
        if (!$adminId) {
            $cookie = $admin->RegisterSet($email, $password, $role);
            return response()->json('admin_created');
        } else {
            return view('admin.create.admin_create_new_layer', ['errMSG' => $this->_message['error_message']['register']]);
        }
        //dd($request->input('register_email'));
        //return response()->redirectTo('/createAdminIndex')->cookie('_zhangfan', $cookie, 60);
    }

    /**
     * 删除管理员的 ajax 方法
     * @param Request $request
     */
    public function doDeleteAjax(Request $request)
    {
        $admin = new Admin();
        $formData = $request->post();
        $adminId = $formData['adminId'];

        $result = $admin->deleteAdmin($adminId);
        //$this->showAdminInfoAjax();
    }

    /**
     * 显示管理员删除后的所有管理员的 ajax 方法
     * @return mix view
     */
    public function showAdminInfoAjax()
    {
        $admin = new Admin();
        $result = $admin->getAllAdminInfo();
        $numberOfSuperAdmin = 0;
        $numberOfAdmin = 0;
        $numberOfdevelper = 0;

        // 将 role 的 1,2,3 等数字转换成中文的 超级管理员，管理员，开发者
        foreach ($result as &$value) {
            if ($value['role'] === 1) {
                $numberOfSuperAdmin++;
            } else if ($value['role'] === 2) {
                $numberOfAdmin++;
            } else if ($value['role'] === 3) {
                $numberOfdevelper++;
            }
            $value['role'] = $this->_role[$value['role']];
        }
        unset($value);

        $numberOfTotalAdmins = count($result);
        $totalAdminInfo = [
            'number_of_total_admins' => $numberOfTotalAdmins,
            'number_of_super_admin'  => $numberOfSuperAdmin,
            'number_of_admin'        => $numberOfAdmin,
            'number_of_develper'     => $numberOfdevelper,
        ];

        return view('admin.info.admin_info_ajax_contents', [
            'adminInfo' => $result,
            'numberOfTotalAdmin' => $totalAdminInfo,
        ]);
    }

    /**
     * 修改管理员密码的 ajax 方法
     * @param Request $request
     * @return json
     */
    public function resetAdminPassword(Request $request)
    {
        $admin = new Admin();
        $formData = $request->post();
        $adminNewPwd = $formData['adminNewPwd'];
        $adminId = $formData['adminId'];
        $data = [
            'admin_id' => $adminId,
        ];
        $result = $admin->updateAdminPwd($adminNewPwd, $data);

        return $result ? response()->json('admin_pwd_updated') : response()->json('admin_pwd_update_err');
    }
}
