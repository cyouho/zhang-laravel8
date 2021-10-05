<?php

namespace App\Http\Controllers\ImageSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Util extends Controller
{
    public static function executePost($postData = [], $formData = [])
    {
        $client = new Client();
        $response = $client->request('POST', $postData['postHost'], [
            'form_params'  => $formData
        ]);
        return $response;
    }

    public static function getFileContents($image)
    {
        $file = file_get_contents($image);
        return $file;
    }

    public static function getRandomString($len, $chars = '')
    {
        if (empty($chars)) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }

        for ($i = 0, $str = '', $lc = strlen($chars) - 1; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $lc)];
        }

        return $str;
    }
}
