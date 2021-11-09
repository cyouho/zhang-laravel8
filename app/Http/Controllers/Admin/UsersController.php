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

        $resetPwdRecord = $admin->getResetUserPwdRecordByID($userData);
        //dd($resetPwdRecord);

        if (isset($result[0])) {
            $viewData = $result[0];
            return view('admin.users.detail.admin_user_detail_layer', [
                'userData'               => $viewData,
                'resetPwdRecord'         => $resetPwdRecord,
                'totalResetTimes'        => count($resetPwdRecord),
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
        // 生成登录 '日期' 记录 '空白' 数组 | 'login_day' | $recordDate.length = $date
        $recordDate = [];

        // 生成登录 '次数' 记录 '空白' 数组 | 'login_times' | $recordTimes.length = $date
        $recordTimes = [];

        for ($i = 0; $i < $date; $i++) {
            // 生成 '指定日期长度'，'指定时间长度' 的数组 | $recordDate, $recordTimes
            $recordDate[$i] = date('Y-m-d', strtotime('-' . $i . 'day'));
            $recordTimes[$i] = 0;
            // 比较指定日期在数据库中是否存在，
            // 如果存在，就将对应日期的登录次数赋值给对应日期的 $recordTimes
            for ($j = 0; $j < count($record); $j++) {
                if ($recordDate[$i] == $record[$j]['login_day']) {
                    $recordTimes[$i] = $record[$j]['login_times'];
                }
            }
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

    /**
     * 获取 user 登陆情况 ajax 方法 
     * @param Request $request
     * @return json $userLoginRecord
     */
    public function userLoginRecordAjax(Request $request)
    {
        $user = new User();
        $postData = $request->post();
        $userId = [
            'user_id' => $postData['userId'],
        ];
        $recordDay = $postData['recordDay'] . ' day';
        $userLoginRecord = $user->getUserLoginRecord($userId, $recordDay);
        $userLoginRecordResult = $this->arrangeUserLoginRecord($userLoginRecord, $recordDay);

        return response()->json($userLoginRecordResult);
    }
}
