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



//分别创建：主页 / 帮助页 / 关于页 的 路由。 
Route::get('/',['as'=>'home','uses'=>'StaticPagesController@forwardHomeView']); 
Route::get('/help',['as'=>'help','uses'=>'StaticPagesController@forwardHelpView']); 
Route::get('/about',['as'=>'about','uses'=>'StaticPagesController@forwardAboutView']); 

//注册使用的路由
Route::get('/signup',['as'=>'signup','uses'=>'UsersController@create']);