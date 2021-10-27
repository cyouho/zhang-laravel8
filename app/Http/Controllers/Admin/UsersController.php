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

    public function showUsersInfoIndex(Request $request)
    {
        $searchRole = $request->input('search_role');
        $searchText = $request->input('search_text');

        $adminName = [
            'admin_id' => $request->input('admin_name'),
        ];

        $data = [
            $this->_userRole[$searchRole] => $searchText,
        ];

        $user = new User();
        $admin = new Admin();
        $result = $user->getUserInfo($data);
        $resetPwdRecord = $admin->getResetUserPwdRecord($adminName);

        if (isset($result[0])) {
            $viewData = $result[0];
            return view('admin.users.detail.admin_user_detail_layer', [
                'userData'       => $viewData,
            ]);
        }

        return view('admin.users.detail.admin_user_detail_layer');
    }

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
        $result = $user->updateUserPwd($password, $data);

        $jsonData = [
            'updated'    => 'updated',
            'update_err' => 'update_err'
        ];

        return $result ? response()->json($jsonData['updated']) : response()->json($jsonData['update_err']);
    }

    public function showResetUserPwdInfo()
    {
        $admin = new Admin();
    }
}
