<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;

/**
 * Register Controller
 */
class RegisterController extends Controller
{
    /**
     * register page.
     */
    public function index()
    {
        return view('register.register');
    }

    /**
     * register function
     */
    public function doRegister(Request $request)
    {
        dd($request->post());
    }
}
