<?php

namespace App\Http\Controllers;

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

    public function imageSearchByDrop()
    {
        return view('dropimg.image_drop_page');
    }
}
