<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Utils;

class User extends Model
{
    use HasFactory;

    public function insert()
    {
    }

    public function get($email)
    {
        $userId = DB::select('select user_id from users where email = ?', [$email]);
        return $userId;
    }

    public function RegisterSet($email, $password)
    {
        $userName = Utils::getUserName($email);
        $session = Utils::getSessionRandomMD5();
        $password = Hash::make($password);
        $timestamp = time();
        $data = [
            'user_name'     => $userName,
            'email'         => $email,
            'password'      => $password,
            'user_session'  => $session,
            'create_at'     => $timestamp,
            'update_at'     => $timestamp,
            'last_login_at' => $timestamp
        ];
        DB::insert('insert into users (user_name, email, password, user_session, create_at, update_at, last_login_at) values (?, ?, ?, ?, ?, ?, ?)', [$data['user_name'], $data['email'], $data['password'], $data['user_session'], $data['create_at'], $data['update_at'], $data['last_login_at']]);

        return $session;
    }
}
