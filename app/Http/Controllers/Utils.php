<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Utils extends Controller
{
    public static function getCookie()
    {
        return request()->cookie('_cyouho');
    }

    public static function getArrFromObj($data)
    {
        return array_map('get_object_vars', $data);
    }
}
