<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
//use App\Http\Controllers\ImageSearchController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ImageSearch\ImageSearchController;
use League\CommonMark\Block\Element\IndentedCode;
use App\Http\Controllers\myPage\myHomePageController;
use App\Http\Controllers\myPage\profileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\Admin;
use App\Http\Controllers\Admin\UsersController;

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
    IndexController::class, 'imageSearchByDrop'
]);

/**
 * 百度, 1688, Alibaba国际, 淘宝的以图搜图路由，暂时不使用！
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

//退出登录按钮
Route::get('logout', [
    LoginController::class, 'doLogout'
]);

Route::get('test', [
    ImageSearchController::class, 'getBaiduImageSearchUrl'
]);

// 现在使用中的搜图路由。
Route::post('imageSearch', [
    ImageSearchController::class, 'imageSearch'
]);

// my page route group.
Route::middleware(['myPage'])->group(function () {
    Route::get('myPage', [
        myHomePageController::class, 'index'
    ]);

    Route::get('profile', [
        profileController::class, 'index'
    ]);

    Route::post('/resetPassword', [
        profileController::class, 'resetPassword'
    ]);
});

// admin route and route group.
Route::get('/admin', [
    AdminController::class, 'index'
]);

Route::post('/adminDoLogin', [
    AdminController::class, 'doLogin'
]);

Route::get('adminLogout', [
    AdminController::class, 'doLogout'
]);

Route::middleware(['admin'])->group(function () {
    Route::get('/adminIndex', [
        AdminController::class, 'adminIndex'
    ]);

    Route::get('/createAdminIndex', [
        AdminController::class, 'createAdminIndex'
    ]);

    Route::post('/createAdmin', [
        AdminController::class, 'doRegister'
    ]);

    Route::get('/showAdminInfo', [
        AdminController::class, 'showAdminInfo'
    ]);

    Route::post('/deleteAdmin', [
        AdminController::class, 'doDeleteAjax'
    ]);

    Route::get('/showAdminInfoAjax', [
        AdminController::class, 'showAdminInfoAjax'
    ]);

    Route::post('/resetAdminPassword', [
        AdminController::class, 'resetAdminPassword'
    ]);

    Route::get('/admin/showUsers', [
        UsersController::class, 'showUsersIndex'
    ]);

    Route::post('/searchUserInfo', [
        UsersController::class, 'showUsersInfoIndex'
    ]);

    Route::post('/resetAdminUserPassword', [
        UsersController::class, 'resetAdminUserPasswordAjax'
    ]);

    Route::post('/showResetPwdRecord', [
        UsersController::class, 'showResetUserPwdInfoAjax'
    ]);
});
