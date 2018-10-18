<?php

Route::group(['prefix'=>'mobile','namespace'=>'Mobile'],function (){

    Route::get('/index','IndexController@index');
    Route::get('/host','IndexController@newVideo');
    Route::get('/list/{token}','IndexController@listVideo')->where('token','[0-9A-Za-z]+');

    Route::get('/register','Auth\RegisterController@index');
    Route::post('/register','Auth\RegisterController@register');
    Route::get('/logout','Auth\LoginController@logout');
    Route::get('/login','Auth\LoginController@index');
    Route::post('/login','Auth\LoginController@login');
    Route::get('/forgot','Auth\ForgotPasswordController@index');
    Route::post('/forgot','Auth\ForgotPasswordController@sendRestPasswordEmail');

    Route::get('/v/{token}','VideoController@index')->where('token','[0-9A-Za-z]+');


    Route::group(['middleware'=>'auth','prefix'=>'member'],function (){

        Route::get('/index','MemberController@index');

        Route::get('/userinfo','UserController@info');
        Route::get('/notice','UserController@notice');
        Route::get('/collect','UserController@collect');

        Route::get('/point','PointController@index');
        Route::get('/pointlog','PointController@log');

        Route::get('/program','ProgramController@index');

    });

});

