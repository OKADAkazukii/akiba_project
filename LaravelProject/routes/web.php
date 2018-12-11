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

Route::get('/home', function () {
    return view('user.home');
});

Route::get('/adduser','UserController@createuser');

Route::get('/user/login', 'LoginController@login');

Route::get('/test', function () {
    return view('test');
});

Route::get('/admin', function () {
    return view('/Admin.signin');
});

Route::get('/signin', function() {
    return view('/Admin.signin');
});

Route::get('/overtime', function() {
    return view('/Admin.overtime');
});

Route::get('/conf', function() {
    return view('/Admin.conf');
});

Route::get('/holyday',function() {
    return view('/Admin.holyday');
});

Route::get('/manager',function() {
    return view('/Admin.manager');
});

Route::get('/detail',function() {
    return view('/Admin.detail');
});

Route::post('/test','Holydays@addholyday');
