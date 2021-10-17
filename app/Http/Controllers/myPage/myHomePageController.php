<?php

namespace App\Http\Controllers\myPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Http\Controllers\Utils;

class myHomePageController extends Controller
{
    private $_session = '';

    private $_user;

    public function __construct()
    {
        $this->_session = Utils::getCookie();
        if (is_null($this->_session)) {
            redirect('/login')->send();
        }
        $this->_user = new User();
    }

    public function index()
    {
        $lastLoginTime = $this->lastLoginTime();
        $totalLoginTimes = $this->totalLoginTimes();
        $myPageData = [
            'lastLoginTime'   => $lastLoginTime,
            'totalLoginTimes' => $totalLoginTimes,
        ];
        return view('mypage.my_home_page_layer', ['myPageData' => $myPageData]);
    }

    public function lastLoginTime()
    {
        $lastLoginTime = $this->_user->getLastLoginTime($this->_session);

        return date("Y-m-d H:i:s", $lastLoginTime[0]['last_login_at']);
    }

    public function totalLoginTimes()
    {
        $totalLoginTimes = $this->_user->getTotalLoginTimes($this->_session);

        return $totalLoginTimes[0]['total_login_times'];
    }
}
