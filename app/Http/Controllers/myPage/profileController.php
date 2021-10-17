<?php

namespace App\Http\Controllers\myPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index()
    {
        return view('myPage.profile.profile_layer');
    }
}
