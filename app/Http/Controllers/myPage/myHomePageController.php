<?php

namespace App\Http\Controllers\myPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Http\Controllers\Utils;

class myHomePageController extends Controller
{
    /**
     * 全局 session 变量。
     */
    private $_session = '';

    /**
     * 全局 User() 对象。
     */
    private $_user;

    /**
     * 构造函数内涵是否登录判定，未登录将跳转到 /login 页面。
     */
    public function __construct()
    {
        $this->_session = Utils::getCookie();
        $this->_user = new User();
    }

    /**
     * my page 入口函数。
     */
    public function index()
    {
        $lastLoginTime = $this->lastLoginTime();
        $totalLoginTimes = $this->totalLoginTimes();
        $registerTime = $this->registerTime();

        // 汇总 my page 页面需要的数据。
        $myPageData = [
            'lastLoginTime'   => $lastLoginTime,
            'totalLoginTimes' => $totalLoginTimes,
            'registerTime'    => $registerTime,
        ];
        return view('mypage.my_home_page_layer', ['myPageData' => $myPageData]);
    }

    /**
     * 最后登录时间。
     */
    public function lastLoginTime()
    {
        $lastLoginTime = $this->_user->getLastLoginTime($this->_session);

        return [
            'year' => date("Y-m-d", $lastLoginTime[0]['last_login_at']),
            'min'  => date("H:i:s", $lastLoginTime[0]['last_login_at']),
        ];
    }

    /**
     * 总登录次数。
     */
    public function totalLoginTimes()
    {
        $totalLoginTimes = $this->_user->getTotalLoginTimes($this->_session);

        return $totalLoginTimes[0]['total_login_times'];
    }

    /**
     * 注册时间。
     */
    public function registerTime()
    {
        $registerTime = $this->_user->getRegisterTime($this->_session);

        return [
            'year' => date("Y-m-d", $registerTime[0]['create_at']),
            'min'  => date("H:i:s", $registerTime[0]['create_at']),
        ];
    }
}
