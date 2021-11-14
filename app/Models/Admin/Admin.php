<?php

namespace App\Models\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Utils;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Utils as ControllersUtils;

class Admin extends Model
{
    use HasFactory;

    private $_role;

    /**
     * 获取 admin 的配置文件内容 | e.g. role (admin 角色)
     */
    public function __construct()
    {
        $this->_role = config('admin.role');
    }

    /**
     * 获取 admin 的 ID
     * @param array $data
     * @return string $adminId 
     */
    public function getAdminId($data)
    {
        $key = key($data);
        $adminId = DB::select('select admin_id from admins where ' . $key . ' = ?', [$data[$key]]);
        if ($key === 'admin_email' && !$adminId) {
            return false;
        }
        $adminId = array_map('get_object_vars', $adminId);

        return $adminId[0]['admin_id'];
    }

    /**
     * 获取 admin 的名字
     * @param string $cookie
     * @return string $adminName
     */
    public function getAdminName($cookie)
    {
        $data = DB::select('select admin_name from admins where admin_session = ?', [$cookie]);
        $adminName = array_map('get_object_vars', $data);

        return $adminName[0]['admin_name'];
    }

    /**
     * 获取 admin 的角色
     * @param array $data
     * @return string
     */
    public function getAdminRole($data)
    {
        $key = key($data);
        $result = DB::select('select role from admins where ' . $key . ' = ?', [$data[$key]]);
        $adminRole = array_map('get_object_vars', $result);

        return $this->_role[$adminRole[0]['role']];
    }

    /**
     * 获取 admin 的session
     * @param string $email
     * @return string $session
     */
    public function getSeesion($email)
    {
        $data = DB::select('select admin_session from admins where admin_email = ?', [$email]);
        $session = $data[0]->admin_session;
        return $session;
    }

    /**
     * 获取 admin 的所有信息
     * @return array $data
     */
    public function getAllAdminInfo()
    {
        $data = DB::select('select admin_id, role, admin_name, admin_email, create_at, last_login_at, total_login_times from admins');
        $data = array_map('get_object_vars', $data);
        return $data;
    }

    /**
     * 获取 admin 的最后登录时间
     * @param string $session
     * @return string
     */
    public function getLastLoginTime($session)
    {
        $data = DB::select('select last_login_at from admins where admin_session = ?', [$session]);
        $result = ControllersUtils::getArrFromObj($data);
        return $result[0]['last_login_at'] ? $result[0]['last_login_at'] : '';
    }

    /**
     * 获取 admin 的总登录次数
     * @param string $session
     * @return string $result
     */
    public function getTotalLoginTimes($session)
    {
        $data = DB::select('select total_login_times from admins where admin_session = ?', [$session]);
        $result = ControllersUtils::getArrFromObj($data);
        return $result[0]['total_login_times'] ? $result[0]['total_login_times'] : '';
    }

    /**
     * 获取 admin 的注册时间
     * @param $session
     * @return string $result
     */
    public function getRegisterTime($session)
    {
        $data = DB::select('select create_at from admins where admin_session = ?', [$session]);
        $result = ControllersUtils::getArrFromObj($data);
        return $result[0]['create_at'] ? $result[0]['create_at'] : '';
    }

    /**
     * 获取 user 重置密码的记录 by ID
     * @param array $data
     * @return array $result
     */
    public function getResetUserPwdRecordByID($data)
    {
        $key = key($data);
        $result = DB::select('select admin_id, user_id, admin_name, update_at from reset_pwd_record where ' . $key . ' = ?', [$data[$key]]);
        $result = ControllersUtils::getArrFromObj($result);
        return isset($result) ? $result : '';
    }

    /**
     * 获取 user 重置密码记录 | 暂时未被使用！
     * @return array $result
     */
    public function getResetUserPwdRecord()
    {
        $result = DB::select('select admin_id, user_id, admin_name, update_at from reset_pwd_record');
        $result = ControllersUtils::getArrFromObj($result);
        return isset($result) ? $result : '';
    }

    /**
     * 获取 admin 的登录记录
     * @param array $data
     * @return array $result | ''
     */
    public function getAdminLoginRecord($data)
    {
        $key = key($data);
        $result = DB::select('select from_unixtime(login_day, "%Y-%m-%d") as login_day, login_times from admin_login_record where ' . $key . ' = ? and date_sub(curdate(), interval 7 day) <= from_unixtime(login_day, "%Y-%m-%d") order by login_day desc', [$data[$key]]);
        $result = ControllersUtils::getArrFromObj($result);

        return isset($result) ? $result : '';
    }

    /**
     * 更新 admin 的最后登录时间
     * @param string $email
     * @param string $loginTime
     */
    public function updateLastLoginTime($email, $loginTime)
    {
        $affected = DB::update('update admins set last_login_at = ? where admin_email = ?', [$loginTime, $email]);
    }

    /**
     * 更新 admin 的总登录次数
     * @param string $email
     */
    public function updateTotalLoginTimes($email)
    {
        $affected = DB::update('update admins set total_login_times = total_login_times + 1 where admin_email = ?', [$email]);
    }

    /**
     * 更新 admin 登录记录里的登录次数
     */
    public function updateAdminLoginTimes($recordId)
    {
        $affected = DB::update('update admin_login_record set login_times = login_times + 1 where record_id = ?', [$recordId]);
    }

    /**
     * 获取 admin 登录记录方法
     */
    public function updateAdminLoginInfo($loginTime, $email)
    {
        $adminId = $this->getAdminId(['admin_email' => $email]);
        $result = DB::select('select record_id, login_day from admin_login_record where from_unixtime(login_day, "%Y%m%d") = curdate() and admin_id = ?', [$adminId]);

        if (!$result) {
            $this->insertAdminLoginRecord($email, $loginTime);
        } else {
            $result = ControllersUtils::getArrFromObj($result);
            $recordId = $result[0]['record_id'];
            $this->updateAdminLoginTimes($recordId);
        }
    }

    /**
     * 检查 admin 的密码
     * @param string $password
     * @param array $data
     * @return bool
     */
    public function checkUserPwd($password, $data)
    {
        $key = key($data);
        $data = DB::select('select admin_password from admins where ' . $key . ' = ?', [$data[$key]]);
        $hashPwd = $data[0]->admin_password;
        return Hash::check($password, (string)$hashPwd);
    }

    /**
     * 注册 admin
     * @param string $email
     * @param string $password
     * @param int $role
     * @return string $session
     */
    public function RegisterSet($email, $password, $role)
    {
        $adminName = Utils::getNameFromEmail($email);
        $session = Utils::getSessionRandomMD5();
        $password = Hash::make($password);
        $timestamp = time();
        $data = [
            'admin_name'        => $adminName,
            'role'              => $role,
            'admin_email'       => $email,
            'admin_password'    => $password,
            'admin_session'     => $session,
            'create_at'         => $timestamp,
            'updated_at'        => $timestamp,
            'last_login_at'     => $timestamp,
            'total_login_times' => 1,
        ];
        DB::insert('insert into admins (role, admin_name, admin_email, admin_password, admin_session, create_at, updated_at, last_login_at, total_login_times) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$data['role'], $data['admin_name'], $data['admin_email'], $data['admin_password'], $data['admin_session'], $data['create_at'], $data['updated_at'], $data['last_login_at'], $data['total_login_times']]);

        // 建立第一次 admin 的登录信息
        $this->insertAdminLoginRecord($adminName, $timestamp);

        return $session;
    }

    public function insertUserPwdUpdateRecord($adminId, $adminName, $userId)
    {
        $timestamp = time();

        $data = [
            'admin_id'           => $adminId,
            'user_id'            => $userId,
            'admin_name'         => $adminName,
            'update_at'          => $timestamp,
        ];
        $affected = DB::insert('insert into reset_pwd_record (admin_id, user_id, admin_name, update_at) values (?, ?, ?, ?)', [$data['admin_id'], $data['user_id'], $data['admin_name'], $data['update_at']]);
    }

    /**
     * 插入 admin 登录记录
     * table: admin_login_record
     * @param string $adminName
     * @param string $timestamp
     */
    public function insertAdminLoginRecord($email, $timestamp)
    {
        $data = [
            'admin_email' => $email,
        ];
        $adminId = $this->getAdminId($data);

        $insertData = [
            'admin_id'    => $adminId,
            'login_day'   => $timestamp,
            'login_times' => 1,
        ];
        $affected = DB::insert('insert into admin_login_record (admin_id, login_day, login_times) values (?, ?, ?)', [$insertData['admin_id'], $insertData['login_day'], $insertData['login_times']]);
    }

    public function deleteAdmin($adminId)
    {
        $affected = DB::delete('delete from admins where admin_id = ?', [$adminId]);

        return $affected;
    }

    public function updateAdminPwd($password, $data)
    {
        $key = key($data);
        $affected = DB::update('update admins set admin_password = ? where ' . $key . ' = ?', [Hash::make($password), $data[$key]]);

        return $affected;
    }
}
