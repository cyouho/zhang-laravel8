<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ImageSearchController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [
    IndexController::class, 'index'
]);

Route::get('/index', [
    IndexController::class, 'index'
]);

//百度以图搜图页面路由
Route::get('/baidu', [
    ImageSearchController::class, 'showBaiduImageSearchHomePage'
]);

//1688以图搜图页面路由
Route::get('1688', [
    ImageSearchController::class, 'showOnesixImageSearchHomePage'
]);

//Alibaba(国际)以图搜图
Route::get('alibaba', [
    ImageSearchController::class, 'showAlibabaImageSearchHomePage'
]);

Route::get('taobao', [
    ImageSearchController::class, 'showTaobaoImageSearchHomePage'
]);

//登录页面的路由
Route::get('login', [
    LoginController::class, 'index'
]);

//登录逻辑
Route::post('dologin', [
    LoginController::class, 'doLogin'
]);

//注册页面的路由
Route::get('register', [
    RegisterController::class, 'index'
]);

//注册逻辑
Route::post('doregister', [
    RegisterController::class, 'doRegister'
]);
