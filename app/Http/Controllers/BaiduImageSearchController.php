<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class BaiduImageSearchController extends Controller
{
    public function index() {
        return view('imgsearch.baidu');
    }
}
