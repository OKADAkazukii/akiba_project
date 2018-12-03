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

Route::get('/test', function () {
    return view('test');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/admin', function () {
    return view('/Admin.login');
});

Route::get('/signin', function() {
    return view('/Admin.signin');
});

Route::get('/user', function() {
    return view('/Admin.user');
});

Route::get('/conf', function() {
    return view('/Admin.conf');
});

Route::get('/add', function() {
    return view('/Admin.add');
});

Route::get('/holyday','AdminController@holyday');
