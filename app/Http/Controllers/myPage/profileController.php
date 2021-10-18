<?php

namespace App\Http\Controllers\myPage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils;
use App\Models\User\User;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index()
    {
        return view('myPage.profile.profile_layer');
    }

    /**
     * profile 修改密码的 ajax 方法。
     */
    public function resetPassword(Request $request)
    {
        $formData = $request->post();
        $oldPwd = $formData['oldPwd'];
        $newPwd = $formData['newPwd'];

        $user = new User();
        $cookie = Utils::getCookie();
        $data = [
            'user_session' => $cookie,
        ];
        if (!$user->checkUserPwd($oldPwd, $data)) {
            return response()->json('pwd_err');
        } else {
            $result = $user->updateUserPwd($newPwd, $data);
            return $result ? response()->json('pwd_updated') : response()->json('pwd_update_err');
        }
    }
}
