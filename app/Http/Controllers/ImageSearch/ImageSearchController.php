<?php

namespace App\Http\Controllers\ImageSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ImageSearch\BaiduImageSearchController;
use App\Http\Controllers\ImageSearch\OnesixImageSearchController;
use App\Http\Controllers\ImageSearch\AlibabaImageSearchController;
use App\Http\Controllers\ImageSearch\TaobaoImageSearchController;

class ImageSearchController extends Controller
{
    /**
     * Define all the sites of image search function.
     */
    private $_imgSearchSiteUrls = [];

    public function __construct()
    {
        $this->_imgSearchSiteUrls = config('siteurls.imageSearch');
    }

    public function imageSearch(Request $request)
    {
        $host = $this->_imgSearchSiteUrls;
        $data = $request->post();
        $site = $data['site'];
        $image = $data['imageUrl'];
        switch ($site) {
            case 'baidu':
                $url = BaiduImageSearchController::getBaiduImageSearchUrl($image, $site, $host);
                break;
            case 'onesix':
                $url = OnesixImageSearchController::getOnesixImageSearchUrl($image, $site, $host);
                break;
            case 'alibaba':
                $url = AlibabaImageSearchController::getAlibabaImageSearch($image, $site, $host);
                break;
            case 'taobao':
                $url = TaobaoImageSearchController::getTaobaoImageSearchUrl($image, $site, $host);
                break;
            default:
                return redirect('/');
                break;
        }
        return response()->json($url);
    }
}
