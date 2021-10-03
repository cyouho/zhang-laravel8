<?php

namespace App\Http\Controllers\ImageSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Util extends Controller
{
    public static function executePost($postData = [], $formData = []) {
        $client = new Client();
        $response = $client->request('POST', $postData['postHost'], [
            'form_params'  => $formData
        ]);
        return $response;
    }
}
