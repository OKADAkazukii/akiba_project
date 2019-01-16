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

Route::get('/admin/home/', 'AdminController@home');

Route::get('/admin/home/empindex/{id}', 'AdminController@index');

Route::get('/admin/home/search', 'AdminController@search');

Route::get('/admin/show/{id}', 'AdminController@show');

Route::get('/admin/show/{id}/edit', 'AdminController@edit');

Route::post('/admin/show/{id}/updata', 'AdminController@updata');

Route::get('/admin/show/{id}/timesearch', 'AdminController@timesearch');

Route::get('/admin/show/{id}/timeedit', 'AdminController@timeedit');

Route::post('/admin/show/{id}/attendanceupdata', 'AdminController@attendanceupdata');

Route::get('/timesettingse', 'SettingController@edit');

Route::post('/timesettingse/change_date_time', 'SettingController@changedatetime');

Route::post('/timesettingse/late_overtime_time', 'SettingController@lateovertimetime');

Route::get('/holiday','HolidayController@holiget');

Route::get('/detail',function() {
    return view('/Admin.detail');
});

Route::post('/holidayupdate','HolidayController@updataholiday');

Route::post('/addholiday', 'HolidayController@addholiday');

Route::get('/employ',function(){
    return view('/Admin.employ');
});

Route::post('/addemp','EmployController@addemp');

Route::get('/conf','UpdateController@update');

Route::get('/manager/{id}','UpdateController@employ');

Route::post('/status/update','UpdateController@editempstatus');

Route::get('/test','CalendarController@test');
