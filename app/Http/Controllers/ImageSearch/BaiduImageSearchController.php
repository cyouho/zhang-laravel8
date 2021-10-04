<?php

namespace App\Http\Controllers\ImageSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageSearch\Util;

class BaiduImageSearchController extends Controller
{
    public static function getBaiduImageSearchUrl($image, $site, $host)
    {
        $postHost = $host['baidu']['postHost'];
        $postData = [
            'image'    => $image,
            'postHost' => $postHost,
            'site'     => $site
        ];
        $formData = [
            'from' => 'pc',
            'image' => $image
        ];

        $response = Util::executePost($postData, $formData);

        //dd(json_decode($response->getBody()->getContents(), true));
        // 测试图片链接: https://m.media-amazon.com/images/I/31qDK-brVYL._SL500_.jpg

        return json_decode($response->getBody()->getContents(), true)['data']['url'] .
            '&pageFrom=graph_upload_bdbox';
    }
}
