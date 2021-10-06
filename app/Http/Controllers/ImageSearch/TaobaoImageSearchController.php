<?php

namespace App\Http\Controllers\ImageSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageSearch\Util;

class TaobaoImageSearchController extends Controller
{
    public static function getTaobaoImageSearchUrl($image, $site, $host)
    {
        $result = Util::uploadTempTmage($image, $site, $host);

        $imageName = $result['name'];

        $url = $host['taobao']['resultHost'] . $imageName . '&app=imgsearch';

        return $url;
    }
}
