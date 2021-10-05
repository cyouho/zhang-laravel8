<?php

namespace App\Http\Controllers\ImageSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageSearch\Util;

class OnesixImageSearchController extends Controller
{
    public static function getOnesixImageSearchUrl($image, $site, $host)
    {
        $timestamp = self::getTimestampForOnesix($site, $host);
        $sign = self::getSignForOnesix($timestamp, $site, $host);
        $url = self::uploadImageForOnesix($image, $site, $sign, $host);
        
        return $url;
    }

    private static function getTimestampForOnesix($site, $host)
    {
        $postHostForTimestamp = $host['onesix']['postHost']['timestamp'];
        $serviceIds = $host['onesix']['serviceIds'];
        $postDataForTimestamp = [
            'postHost' => $postHostForTimestamp,
            'site'     => $site
        ];
        $formDataForTimestamp = [
            'serviceIds' => $serviceIds,
            'outfmt'     => 'json'
        ];
        $timestampResponse = Util::executePost($postDataForTimestamp, $formDataForTimestamp);
        //dd($timestampResponse->getBody()->getContents());
        $timestamp = (string)json_decode($timestampResponse->getBody()->getContents(), true)[$serviceIds]['dataSet'];
        return $timestamp;
    }

    private static function getSignForOnesix($timestamp, $site, $host)
    {
        $appKeyTemp = utf8_encode('pc_tusou' . ';' . $timestamp);
        $appKey = base64_encode($appKeyTemp);
        $postHostForSign = $host['onesix']['postHost']['sign'];
        $postDataForSign = [
            'postHost' => $postHostForSign,
            'site'     => $site
        ];
        $formDataForSign = [
            'appName' => 'pc_tusou',
            'appKey'  => $appKey
        ];
        $signResponse = Util::executePost($postDataForSign, $formDataForSign);

        //dd($signResponse->getBody()->getContents());

        return json_decode($signResponse->getBody(), true);
    }

    private static function uploadImageForOnesix($image, $site, $sign, $host)
    {
        $postTimestamp = (string)time() * 1000;
        $key = 'cbuimgsearch' . Util::getRandomString($len = 10) .
            (string)$postTimestamp . '.jpg';
        $name = Util::getRandomString($len = 5) . '.jpg';
        $file = Util::getFileContents($image);

        $postDateForUrl = [
            'postHost' => $host['onesix']['postHost']['img'],
        ];

        $formDateForUrl = [
            'name'                  => $name,
            'key'                   => $key,
            'policy'                => $sign['policy'],
            'OSSAccessKeyId'        => $sign['accessid'],
            'success_action_status' => 200,
            'callback'              => '',
            'signature'             => $sign['signature'],
            'file'                  => $file,
        ];

        Util::executePost($postDateForUrl, $formDateForUrl);

        $url = $host['onesix']['resualtHost'] . $key;
        return $url;
    }
}
