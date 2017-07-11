<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin/code',['as'=>'admin/code','uses'=>'Admin\LoginController@code']);
Route::match(['get','post'],'admin/login',['as'=>'admin/login','uses'=>'Admin\LoginController@login']);
Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
    //退出登录
    Route::get('quitlogin',['as'=>'admin/quitlogin','uses'=>'LoginController@quitlogin']);
    //首页
    Route::get('index',['as'=>'admin/index','uses'=>'IndexController@index']);
    //文章增删改查
    Route::get('article',['as'=>'admin/article','uses'=>'ArticleController@article']);
    Route::any('add_article',['as'=>'admin/add_article','uses'=>'ArticleController@add_article']);
    Route::any('up_article/{id}',['as'=>'admin/up_article','uses'=>'ArticleController@up_article'])->where(['id'=>'\d+']);
    Route::any('del_article',['as'=>'admin/del_article','uses'=>'ArticleController@del_article']);
    //登录日志
    Route::get('loginlog',['as'=>'admin/loginlog','uses'=>'UserController@loginlog']);
    Route::match(['get','post'],'delloginlog/{id?}',['as'=>'admin/delloginlog','uses'=>'UserController@loginlogdelete'])->where(['id'=>'\d+']);
    Route::resource('user', 'UserController');
    //用户信息更新
    Route::any('up_userinfo',['as'=>'admin/up_userinfo','uses'=>'IndexController@up_userinfo']);
    //栏目增删改查
    Route::resource('column', 'ColumnController');
    //菜单扩展
    Route::resource('menu', 'MenuController');
});

