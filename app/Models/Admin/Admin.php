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

    public function __construct()
    {
        $this->_role = config('admin.role');
    }

    /**
     * 
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

    public function getAdminName($cookie)
    {
        $data = DB::select('select admin_name from admins where admin_session = ?', [$cookie]);
        $adminName = array_map('get_object_vars', $data);

        return $adminName[0]['admin_name'];
    }

    /**
     * 
     */
    public function getAdminRole($data)
    {
        $key = key($data);
        $result = DB::select('select role from admins where ' . $key . ' = ?', [$data[$key]]);
        $adminRole = array_map('get_object_vars', $result);

        return $this->_role[$adminRole[0]['role']];
    }

    public function getSeesion($email)
    {
        $data = DB::select('select admin_session from admins where admin_email = ?', [$email]);
        $session = $data[0]->admin_session;
        return $session;
    }

    public function getAllAdminInfo()
    {
        $data = DB::select('select admin_id, role, admin_name, admin_email, create_at, last_login_at, total_login_times from admins');
        $data = array_map('get_object_vars', $data);
        return $data;
    }

    public function getLastLoginTime($session)
    {
        $data = DB::select('select last_login_at from admins where admin_session = ?', [$session]);
        $result = ControllersUtils::getArrFromObj($data);
        return $result[0]['last_login_at'] ? $result[0]['last_login_at'] : '';
    }

    public function getTotalLoginTimes($session)
    {
        $data = DB::select('select total_login_times from admins where admin_session = ?', [$session]);
        $result = ControllersUtils::getArrFromObj($data);
        return $result[0]['total_login_times'] ? $result[0]['total_login_times'] : '';
    }

    public function getRegisterTime($session)
    {
        $data = DB::select('select create_at from admins where admin_session = ?', [$session]);
        $result = ControllersUtils::getArrFromObj($data);
        return $result[0]['create_at'] ? $result[0]['create_at'] : '';
    }

    public function updateLastLoginTime($email)
    {
        $affected = DB::update('update admins set last_login_at = ? where admin_email = ?', [time(), $email]);
    }

    public function updateTotalLoginTimes($email)
    {
        $affected = DB::update('update admins set total_login_times = total_login_times + 1 where admin_email = ?', [$email]);
    }

    public function checkUserPwd($password, $data)
    {
        $key = key($data);
        $data = DB::select('select admin_password from admins where ' . $key . ' = ?', [$data[$key]]);
        $hashPwd = $data[0]->admin_password;
        return Hash::check($password, (string)$hashPwd);
    }

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

        return $session;
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
