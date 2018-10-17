<?php

Route::get('/','HomeController@index');
Route::get('/list/{id}','HomeController@list');
Route::get('/logout','Auth\LoginController@logout')->name('logout');

Route::get('/spread','SpreadController@index');

Route::get('/v/{token}','VideoController@index')->middleware('web')->where('token','[0-9A-Za-z]+');
Route::post('/change-server','MemberController@serverApi');
Route::post('/rand-video','VideoController@randVideo');
Route::get('/search','VideoController@search');

Route::get('/help/rule','HomeController@rule');
Route::get('/help/privacy','HomeController@privacy');
Route::get('/help/disclaimer','HomeController@disclaimer');

Route::group(['middleware'=>'auth','prefix'=>'member'],function (){

    Route::get('/','MemberController@index');
    Route::get('/notify/{id}','MemberController@notify')->where('id','[0-9A-Za-z]+');
    Route::get('/info','UserController@index');
    Route::put('/info/username','UserController@updateUserName');
    Route::put('/info/password','UserController@updatePassword');
    Route::delete('/collect/{token}','UserController@removeCollect')->where('token','[0-9A-Za-z]+');

    Route::get('/collect','UserController@collectVideo');

    Route::get('/point','PointController@index');
    Route::post('/point','PointController@activeCode');
    Route::get('/point-log','PointController@pointLog');
    Route::post('/pay-video','PointController@payVideo');

    Route::post('/program','ProgramController@activeProgram');

    Route::post('/collect','VideoController@collectVideo');
    Route::post('/reflect','VideoController@reflect');

});
include_once 'mobile.php';
include_once 'admin.php';
Auth::routes();

