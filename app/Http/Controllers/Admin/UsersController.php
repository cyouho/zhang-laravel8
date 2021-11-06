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

        $userData = [
            'user_id' => isset($result[0]['user_id']) ? $result[0]['user_id'] : '',
        ];

        $userLoginRecordOn7Day = $user->getUserLoginRecord($userData);
        $userLoginRecordOn14Day = $user->getUserLoginRecord($userData, $day = '14 day');
        $userLoginRecordOn30Day = $user->getUserLoginRecord($userData, $day = '30 day');
        $userLoginRecordOn7DayResult = $this->arrangeUserLoginRecord($userLoginRecordOn7Day, $date = 7);
        $userLoginRecordOn14DayResult = $this->arrangeUserLoginRecord($userLoginRecordOn14Day, $date = 14);
        $userLoginRecordOn30DayResult = $this->arrangeUserLoginRecord($userLoginRecordOn30Day, $date = 30);


        $resetPwdRecord = $admin->getResetUserPwdRecordByID($userData);
        //dd($resetPwdRecord);

        if (isset($result[0])) {
            $viewData = $result[0];
            return view('admin.users.detail.admin_user_detail_layer', [
                'userData'               => $viewData,
                'resetPwdRecord'         => $resetPwdRecord,
                'totalResetTimes'        => count($resetPwdRecord),
                'userLoginRecordOn7Day'  => $userLoginRecordOn7DayResult,
                'userLoginRecordOn14Day' => $userLoginRecordOn14DayResult,
                'userLoginRecordOn30Day' => $userLoginRecordOn30DayResult,
            ]);
        }

        return view('admin.users.detail.admin_user_detail_layer');
    }

    /**
     * 整理 user 登录记录
     */
    public function arrangeUserLoginRecord($record, $date)
    {
        // 处理返回首页的数据
        for ($i = 0; $i < $date; $i++) {
            if (!isset($record[$i])) {
                array_push($record, [
                    'login_day'   => date('Y-m-d', strtotime('-' . $i . 'day')),
                    'login_times' => 0,
                ]);
            }
        }

        $recordDate = [];
        array_pad($recordDate, $date, '');
        $recordTimes = [];
        array_pad($recordTimes, $date, 0);

        foreach ($record as $key => $value) {
            $recordDate[$key] = $value['login_day'];
            $recordTimes[$key] = $value['login_times'];
        }


        return [
            'date'  => array_reverse($recordDate),
            'times' => array_reverse($recordTimes),
        ];
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
        $admin->insertUserPwdUpdateRecord($formData['adminId'], $formData['adminName'], $data['user_id']);

        $jsonData = [
            'updated'    => 'updated',
            'update_err' => 'update_err'
        ];

        return $result ? response()->json($jsonData['updated']) : response()->json($jsonData['update_err']);
    }

    /**
     * 管理员修改密码记录的 ajax 方法
     */
    public function showResetUserPwdInfoAjax(Request $request)
    {
        $admin = new Admin();

        $formData = $request->post();
        $userId = [
            'user_id' => $formData['user_id'],
        ];
        $resetPwdRecord = $admin->getResetUserPwdRecordByID($userId);

        return view('admin.users.detail.admin_user_detail_reset_user_pwd_ajax', [
            'resetPwdRecord'  => $resetPwdRecord,
            'totalResetTimes' => count($resetPwdRecord),
        ]);
    }
}
