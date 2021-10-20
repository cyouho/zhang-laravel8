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
    public function getUserId($email)
    {
        $userId = DB::select('select user_id from users where email = ?', [$email]);
        return $userId;
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
    public function updateLastLoginTime($email)
    {
        $affected = DB::update('update users set last_login_at = ? where email = ?', [time(), $email]);
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

        return $session;
    }
}
