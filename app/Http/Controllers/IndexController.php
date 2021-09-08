<?php

namespace App\Http\Controllers;

use View;
use DB;

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
        //return DB::select('select * from connect_test.connect_table');
        return view('index.index');
    }

    public function index2()
    {
        return view('index.new_index');
    }
}
