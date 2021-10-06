<?php

namespace App\Http\Controllers\ImageSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageSearch\Util;

class AlibabaImageSearchController extends Controller
{
    public static function getAlibabaImageSearch($image, $site, $host)
    {
        $result = Util::uploadTempTmage($image, $site, $host);

        $imageUrl = $result['fs_url'];

        $url = $host['alibaba']['resultHost'] . $imageUrl . '&sourceFrom=imageupload';

        return $url;
    }
}
