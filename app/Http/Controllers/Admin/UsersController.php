<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function showUsersIndex()
    {
        return view('admin.users.admin_users_layer');
    }

    public function showUsersInfoIndexAjax()
    {
    }
}
