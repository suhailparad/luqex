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

//Admin
    Route::get('/admin','AdminController@index');

    Route::get('/admin/packages','PackageController@index');
    Route::post('/admin/package/save','PackageController@save');
    Route::post('/admin/package/update','PackageController@update');
    Route::post('/admin/package/delete','PackageController@delete');

