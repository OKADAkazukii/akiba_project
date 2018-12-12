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

Route::get('/home/{login_hash}', 'EmployeeController@home');

Route::post('/starttime','AttendanceController@starttime');

Route::post('/finishtime','AttendanceController@finishtime');

Route::post('/resttime','AttendanceController@resttime');

Route::get('/addemployee','EmployeeController@addemployee');

Route::post('/create/employee','EmployeeController@create');

Route::get('/employee/login', 'EmployeeController@login');

Route::get('/test', function () {
    return view('test');
});

Route::get('/admin/home/', 'AdminController@home');

Route::get('/timesettingse', 'SettingController@edit');

Route::post('/timesettingse/change_date_time', 'SettingController@changedatetime');

Route::post('/timesettingse/late_overtime_time', 'SettingController@lateovertimetime');

Route::get('/conf', function() {
    return view('/Admin.conf');
});

Route::get('/holiday',function() {
    return view('/Admin.holiday');
});

Route::get('/manager',function() {
    return view('/Admin.manager');
});

Route::get('/detail',function() {
    return view('/Admin.detail');
});

Route::post('/test','Holydays@addholyday');

Route::post('/holidayupdate','HolidayController@updataholiday');

Route::post('/test', 'HolidayController@addholiday');

Route::get('/employ',function(){
    return view('/Admin.employ');
});

Route::post('/addemp','EmployController@addemp');