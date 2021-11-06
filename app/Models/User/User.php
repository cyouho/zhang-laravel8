<?php

namespace App\Models\User;

use App\Http\Controllers\Utils as ControllersUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Utils;

class User extends Model
{
    use HasFactory;

    /**
     * 
     */
    public function getUserId($data)
    {
        $key = key($data);
        $userId = DB::select('select user_id from users where ' . $key . ' = ?', [$data[$key]]);

        return isset($userId[0]) ? $userId : '';
    }

    /**
     * 
     */
    public function getSeesion($email)
    {
        $data = DB::select('select user_session from users where email = ?', [$email]);
        $session = $data[0]->user_session;
        return $session;
    }

    /**
     * 
     */
    public function checkUserPwd($password, $data)
    {
        $key = key($data);
        $data = DB::select('select password from users where ' . $key . ' = ?', [$data[$key]]);
        $hashPwd = $data[0]->password;
        return Hash::check($password, (string)$hashPwd);
    }

    /**
     * 
     */
    public function updateUserPwd($password, $data)
    {
        $key = key($data);
        $affected = DB::update('update users set password = ? where ' . $key . ' = ?', [Hash::make($password), $data[$key]]);
        return $affected;
    }

    /**
     * 
     */
    public function updateLastLoginTime($loginTime, $email)
    {
        $affected = DB::update('update users set last_login_at = ? where email = ?', [$loginTime, $email]);
    }

    /**
     * 
     */
    public function updateTotalLoginTimes($email)
    {
        $affected = DB::update('update users set total_login_times = total_login_times + 1 where email = ?', [$email]);
    }

    /**
     * 
     */
    public function getUserName($session)
    {
        $data = DB::select('select user_name from users where user_session = ?', [$session]);
        $userName = array_map('get_object_vars', $data);

        return $userName[0]['user_name'];
    }

    /**
     * 
     */
    public function getLastLoginTime($session)
    {
        $data = DB::select('select last_login_at from users where user_session = ?', [$session]);
        return ControllersUtils::getArrFromObj($data);
    }

    /**
     * 
     */
    public function getTotalLoginTimes($session)
    {
        $data = DB::select('select total_login_times from users where user_session = ?', [$session]);
        return ControllersUtils::getArrFromObj($data);
    }

    /**
     * 
     */
    public function getRegisterTime($session)
    {
        $data = DB::select('select create_at from users where user_session = ?', [$session]);
        return ControllersUtils::getArrFromObj($data);
    }

    public function getUserInfo($data)
    {
        $key = key($data);
        $result = DB::select('select user_id, user_name, email, create_at, last_login_at, total_login_times from users where ' . $key . ' = ?', [$data[$key]]);
        return ControllersUtils::getArrFromObj($result);
    }

    /**
     * 获取 user 近7天登录记录
     */
    public function getUserLoginRecord($data, $day = '7 day')
    {
        $key = key($data);
        $result = DB::select('select from_unixtime(login_day, "%Y-%m-%d") as login_day, login_times from user_login_record where ' . $key . ' = ? and date_sub(curdate(), interval ' . $day . ') <= from_unixtime(login_day, "%Y-%m-%d") order by login_day desc', [$data[$key]]);
        $result = ControllersUtils::getArrFromObj($result);

        return isset($result) ? $result : '';
    }

    /**
     * 获取 user 登录记录方法
     */
    public function updateAdminLoginInfo($loginTime, $email)
    {
        $userId = $this->getUserId(['email' => $email]);
        $result = DB::select('select record_id, login_day from user_login_record where from_unixtime(login_day, "%Y%m%d") = curdate() and user_id = ?', [$userId[0]->user_id]);

        // 如果没有这天的记录就插入新的记录
        if (!$result) {
            $this->insertUserLoginRecord($email, $loginTime);
        } else {
            // 如果有记录就获取记录
            $result = ControllersUtils::getArrFromObj($result);
            $recordId = $result[0]['record_id'];
            // 更新一次登录次数
            $this->updateUserLoginTimes($recordId);
        }
    }

    /**
     * 更新 user 登录记录里的登录次数
     */
    public function updateUserLoginTimes($recordId)
    {
        $affected = DB::update('update user_login_record set login_times = login_times + 1 where record_id = ?', [$recordId]);
    }

    /**
     * 
     */
    public function RegisterSet($email, $password)
    {
        $userName = Utils::getNameFromEmail($email);
        $session = Utils::getSessionRandomMD5();
        $password = Hash::make($password);
        $timestamp = time();
        $data = [
            'user_name'         => $userName,
            'email'             => $email,
            'password'          => $password,
            'user_session'      => $session,
            'create_at'         => $timestamp,
            'update_at'         => $timestamp,
            'last_login_at'     => $timestamp,
            'total_login_times' => 1,
        ];
        DB::insert('insert into users (user_name, email, password, user_session, create_at, update_at, last_login_at, total_login_times) values (?, ?, ?, ?, ?, ?, ?, ?)', [$data['user_name'], $data['email'], $data['password'], $data['user_session'], $data['create_at'], $data['update_at'], $data['last_login_at'], $data['total_login_times']]);

        // 建立第一次 user 的登录信息
        $this->insertUserLoginRecord($email, $timestamp);

        return $session;
    }

    /**
     * 插入 user 登录记录
     * table: user_login_record
     * @param string $email
     * @param string $timestamp
     */
    public function insertUserLoginRecord($email, $timestamp)
    {
        $data = [
            'email' => $email,
        ];
        $result = $this->getUserId($data);
        $userId = isset($result[0]->user_id) ? $result[0]->user_id : '';

        $insertData = [
            'user_id'     => $userId,
            'login_day'   => $timestamp,
            'login_times' => 1,
        ];
        $affected = DB::insert('insert into user_login_record (user_id, login_day, login_times) values (?, ?, ?)', [$insertData['user_id'], $insertData['login_day'], $insertData['login_times']]);
    }
}
