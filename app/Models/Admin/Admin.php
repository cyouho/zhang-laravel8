<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Utils;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    use HasFactory;

    /**
     * 
     */
    public function getAdminId($email)
    {
        $adminId = DB::select('select admin_id from admins where admin_email = ?', [$email]);
        return $adminId;
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
    public function getAdminRole($email)
    {
        $adminRole = DB::select('select role from admins where admin_email = ?', [$email]);
        return $adminRole;
    }

    public function getSeesion($email)
    {
        $data = DB::select('select admin_session from admins where admin_email = ?', [$email]);
        $session = $data[0]->admin_session;
        return $session;
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
}
