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
        $this->_defaultSiteUrls = config('siteurls.imageSearch');
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
     * (use guzzle client)
     */
    public function test()
    {
        $client = new Client();

        $baiduImgPostHost = $this->_defaultSiteUrls['postHost']['baidu'];

        $response = $client->request('POST', $baiduImgPostHost, [
            'form_params'  => [
                'from'  => 'pc',
                'image' => 'https://m.media-amazon.com/images/I/31qDK-brVYL._SL500_.jpg'
            ]
        ]);

        //dd(json_decode($response->getBody()->getContents(), true));

        return json_decode($response->getBody()->getContents(), true)['data']['url'] . '&pageFrom=graph_upload_bdbox';
    }
}
