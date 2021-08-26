<?php

namespace App\Http\Controllers;

use View;

/**
 * ホームページclass
 */
class IndexController extends Controller
{
    /**
     * ホームページIndex
     */
    public function index()
    {
        return view('index.index');
    }
}
