<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

/**
 * Main function for image search.
 */
class ImageSearchController extends Controller
{
    /**
     * Show image search home page for baidu.
     */
    public function baidu()
    {
        return view('imgsearch.baidu');
    }

    /**
     * Show image search home page for 1688.
     */
    public function onesix()
    {
        return view('imgsearch.1688');
    }

    /**
     * Show image search home page for alibaba.
     */
    public function alibaba()
    {
        return view('imgsearch.alibaba');
    }

    /**
     * Show image search home page for taobao.
     */
    public function taobao()
    {
        return view('imgsearch.taobao');
    }

    /**
     * Image search function for baidu.
     */
    public function baiduImageSearch()
    {
    }
}
