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

    public static function uploadTempTmage($image, $site, $host)
    {
        $file = self::getFileContents($image);

        $temp = tmpfile();
        fwrite($temp, $file);

        if (file_exists(stream_get_meta_data($temp)['uri']) && file_get_contents(stream_get_meta_data($temp)['uri'])) {
            $path = stream_get_meta_data($temp)['uri'];
        } else {
            return false;
        }

        switch ($site) {
            case 'taobao':
                $formData = [
                    'imgfile' => curl_file_create($path, 'image/jpeg'),
                ];
                $postData = [
                    'postHost' => $host['taobao']['postHost']
                ];
                $result = self::executePost($formData, $postData);
            case 'alibaba':
                $imageName = self::getRandomString($len = 5);
                $formData = [
                    'file'  => curl_file_create($path, 'image/jpeg'),
                    'scene' => 'scImageSearchNsRule',
                    'name'  => (string)$imageName . '.jpg'
                ];
                $postData = [
                    'postHost' => $host['alibaba']['postHost']
                ];
                $result = self::executePost($formData, $postData);
                break;
            default:
                $result = false;
        }
        fclose($temp);
        return $result;
    }
}
