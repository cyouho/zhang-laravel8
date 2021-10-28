<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Admin\Admin;

class UsersController extends Controller
{
    private $_userRole = [];

    private $_resetPwdAdmin = [];

    public function __construct()
    {
        $this->_userRole = config('user.role');
    }

    public function showUsersIndex()
    {
        return view('admin.users.admin_users_layer');
    }

    /**
     * 第一次通过form提交查询到的用户详细信息页面
     */
    public function showUsersInfoIndex(Request $request)
    {
        $searchRole = $request->input('search_role');
        $searchText = $request->input('search_text');
        $adminId = [
            'admin_id' => $request->input('admin_id'),
        ];

        $data = [
            $this->_userRole[$searchRole] => $searchText,
        ];

        $user = new User();
        $admin = new Admin();
        $result = $user->getUserInfo($data);
        $resetPwdRecord = $admin->getResetUserPwdRecord($adminId);
        //dd($resetPwdRecord);

        if (isset($result[0])) {
            $viewData = $result[0];
            return view('admin.users.detail.admin_user_detail_layer', [
                'userData'        => $viewData,
                'resetPwdRecord'  => $resetPwdRecord,
                'totalResetTimes' => count($resetPwdRecord),
            ]);
        }

        return view('admin.users.detail.admin_user_detail_layer');
    }

    /**
     * 通过ajax的post方法修改用户密码的方法
     */
    public function resetAdminUserPasswordAjax(Request $request)
    {
        $formData = $request->post();
        $this->_resetPwdAdmin = [
            'admin_id'   => $formData['adminId'],
            'admin_name' => $formData['adminName'],
        ];
        $password = $formData['resetUserPwd'];
        $data = [
            'user_id' => $formData['resetUserId'],
        ];
        $user = new User();
        $admin = new Admin();
        $result = $user->updateUserPwd($password, $data);
        $admin->insertUserPwdUpdateRecord($formData['adminId'], $formData['adminName']);

        $jsonData = [
            'updated'    => 'updated',
            'update_err' => 'update_err'
        ];

        return $result ? response()->json($jsonData['updated']) : response()->json($jsonData['update_err']);
    }

    public function showResetUserPwdInfo(Request $request)
    {
        $admin = new Admin();
        $formData = $request->post();
        $adminId = [
            'admin_id' => $formData['admin_id'],
        ];
        $resetPwdRecord = $admin->getResetUserPwdRecord($adminId);

        return view('admin.users.detail.admin_user_detail_reset_user_pwd_ajax', [
            'resetPwdRecord'  => $resetPwdRecord,
            'totalResetTimes' => count($resetPwdRecord),
        ]);
    }
}
