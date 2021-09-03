<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

class ImageSearchController extends Controller
{
    public function baidu(){
        return view('imgsearch.baidu');
    }

    public function onesix(){
        return view('imgsearch.1688');
    }
}
