<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use GuzzleHttp\Client;

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
        $this->_imgSearchSiteUrls = config('siteurls.imageSearch');
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

    public function imageSearch(Request $request)
    {
        $data = $request->post();
        $site = $data['site'];
        $image = $data['imageUrl'];
        switch ($site) {
            case 'baidu':
                $url = $this->getBaiduImageSearchUrl($image, $site);
                break;
            default:
                return redirect('/');
                break;
        }
        return response()->json($url);
    }

    /**
     * get Image search URL function for baidu.
     * (use guzzle client)
     */
    public function getBaiduImageSearchUrl($image, $site)
    {
        $postHost = $this->_imgSearchSiteUrls['postHost']['baidu'];
        $postData = [
            'image'    => $image,
            'postHost' => $postHost,
            'site'     => $site
        ];
        $formData = [
            'from' => 'pc',
            'image' => $image
        ];

        $response = $this->executePost($postData, $formData);

        //dd(json_decode($response->getBody()->getContents(), true));
        // 测试图片链接: https://m.media-amazon.com/images/I/31qDK-brVYL._SL500_.jpg

        return json_decode($response->getBody()->getContents(), true)['data']['url'] . '&pageFrom=graph_upload_bdbox';
    }

    public function getOnesixImageSearchUrl($image, $site)
    {
        $postHostForTimestamp = $this->_imgSearchSiteUrls['postHost']['onesix']['timestamp'];
        $postDataForTimestamp = [
            'postHost' => $postHostForTimestamp,
            'site'     => $site
        ];
        $formDataForTimestamp = [
            'serviceIds' => 'cbu.searchweb.config.system.currenttime',
            'outfmt'     => 'json'
        ];
        $timestampResponse = $this->executePost($postDataForTimestamp, $formDataForTimestamp);
    }

    /**
     * 
     */
    private function executePost($postData = [], $formData = [])
    {
        $client = new Client();
        $response = $client->request('POST', $postData['postHost'], [
            'form_params'  => $formData
        ]);
        return $response;
    }
}
