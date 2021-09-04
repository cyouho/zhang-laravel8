<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ImageSearchController;

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
    ImageSearchController::class, 'baidu'
]);

//1688以图搜图页面路由
Route::get('1688', [
    ImageSearchController::class, 'onesix'
]);

//Alibaba(国际)以图搜图
Route::get('alibaba', [
    ImageSearchController::class, 'alibaba'
]);

//登录页面的路由，包含登录验证中间件
Route::get('login', function () {
    return view('login.login');
})->middleware('login');

//注册页面的路由
Route::get('register', function () {
    return view('register.register');
});
