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


Route::get('/goods','Api\TestController@goods');

Route::get('/de','Api\TestController@de');
Route::get('/de2','Api\TestController@de2');

Route::get('/red1','Api\TestController@red1');

Route::get('/curl1','Api\TestController@curl1');
Route::get('/curl2','Api\TestController@curl2');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 用户管理
Route::get('/user/addkey','User\IndexController@addSSHKey1');
Route::post('/user/addkey','User\IndexController@addSSHKey2');

//解密数据
Route::get('/user/decrypt/data','User\IndexController@decrypt');
Route::post('/user/decrypt/data','User\IndexController@decrypt2');
