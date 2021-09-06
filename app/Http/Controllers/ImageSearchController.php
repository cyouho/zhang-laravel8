<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

/**
 * Main function for image search.
 */
class ImageSearchController extends Controller
{
    /**
     * Define all the sites of image search function.
     */
    private $_defaultSiteUrls = [];

    /**
     * Get contents of config file.
     */
    public function __construct()
    {
        $this->_defaultSiteUrls = config('siteurls');
    }

    /**
     * Select which site will be shown.
     */
    public function showSiteImageSearchHomePage($site = 'others')
    {
        switch ($site) {
            case 'baidu':
                return view('imgsearch.baidu');
                break;
            case '1688':
                return view('imgsearch.1688');
                break;
            case 'alibaba':
                return view('imgsearch.alibaba');
                break;
            case 'taobao':
                return view('imgsearch.taobao');
                break;
            default:
                return redirect('/');
                break;
        }
    }

    /**
     * get Image search URL function for baidu.
     */
    private function getBaiduImageSearchUrl($image, $site)
    {
        $postData = [
            'from' => 'pc',
            'image' => $image,
        ];
        $postData = http_build_query($postData);

        $result = $this->uploadImage($postData, $this->siteHosts['baidu']['post']['url'], $site);

        if (!$result) {
            return $this->getDefaultSiteUrl($site);
        } else {
            $sign = $result['data']['sign'];
        }

        // create image search url for baidu.
        $url = $this->siteHosts['baidu']['result']['url'] . $sign . '&f=all&tn=pc&tpl_from=pc';

        return $url;
    }

    /**
     * Alias for get CURL result.
     */
    private function uploadImage($postdata, $url, $site)
    {
        return $this->getCurlResult($postdata, $url, $site);
    }

    /**
     * Get CURL result.
     */
    private function getCurlResult($postdata = null, $url = null, $site = null, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $curlResult = [
            'httpCode' => $httpCode,
            'content' => $result,
        ];

        $curlResult = $this->cURLOfImageSearchExceptionalHandling($curlResult, $site);

        return $curlResult;
    }
}
