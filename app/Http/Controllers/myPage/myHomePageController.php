<?php

namespace App\Http\Controllers\myPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class myHomePageController extends Controller
{
    public function index()
    {
        return view('mypage.my_home_page_layer');
    }
}
