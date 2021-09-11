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
    IndexController::class, 'index2'
]);

Route::get('/index', [
    IndexController::class, 'index2'
]);

Route::get('/index2', [
    IndexController::class, 'index2'
]);

/**
 * 百度, 1688, Alibaba国际, 淘宝的以图搜图路由
 */
Route::get('imgsearch/{site?}', [
    ImageSearchController::class, 'showSiteImageSearchHomePage'
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

Route::get('test', [
    ImageSearchController::class, 'getBaiduImageSearchUrl'
]);

Route::post('imageSearch', [
    ImageSearchController::class, 'imageSearch'
]);
