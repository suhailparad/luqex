<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/register','HomeController@getRegister');
Route::post('/register','HomeController@doRegister');
Route::get('/login','HomeController@getLogin');
Route::post('/login','HomeController@doLogin');

Route::get('/logout','HomeController@doLogout');

//Admin
Route::group(['middleware' => ['admin','preventBackHistory']], function(){
    Route::get('/admin','AdminController@index');

    Route::get('/admin/packages','PackageController@index');
    Route::post('/admin/package/save','PackageController@save');
    Route::post('/admin/package/update','PackageController@update');
    Route::post('/admin/package/delete','PackageController@delete');

    Route::get('/admin/subscribers','SubscriberController@index');
    Route::post('/admin/subscribers/update-status','SubscriberController@updateStatus');
});
//Subscriber
Route::group(['middleware' => ['subscriber','preventBackHistory']], function(){
    Route::get('/user','UserController@index');

    Route::get('/user/apps','ApplicationController@index');
    Route::post('/user/app/save','ApplicationController@save');
    Route::post('/user/app/update','ApplicationController@update');
    Route::post('/user/app/delete','ApplicationController@delete');
    Route::post('/user/app/toggle-status','ApplicationController@toggle');

    //Hit Controller
    Route::get('/user/app/{id}/hit','HitController@singleHit');
    Route::get('/user/apps/{id}/logs','HitController@getLog');
});
