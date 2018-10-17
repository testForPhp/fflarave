<?php

Route::group(['namespace'=>'Admin','prefix'=>'/master/admin'],function ()
{

    Route::get('/login','LoginController@index')->name('login');
    Route::post('/login','LoginController@store');

    Route::group(['middleware'=>'auth:admin'],function ()
    {
        Route::get('/index','HomeController@index');
        /*****************System setting**************************/
        Route::get('/system/setting','SystemController@index');
        Route::post('/system/setting','SystemController@store');
        /*****************System server**************************/
        Route::get('/system/server','ServerController@index');
        Route::get('/system/server/create','ServerController@create');
        Route::post('/system/server/create','ServerController@store');
        Route::get('/system/server/{id}/edit','ServerController@edit')->where('id','[0-9]+');
        Route::delete('/system/server/{id}','ServerController@destroy')->where('id','[0-9]+');
        /*****************System notify**************************/
        Route::get('/system/notify','NotifyController@index');
        Route::get('/system/notify/create','NotifyController@create');
        Route::post('/system/notify/create','NotifyController@store');
        Route::get('/system/notify/{id}/edit','NotifyController@edit')->where('id','[0-9]+');
        Route::delete('/system/notify/{id}','NotifyController@destroy')->where('id','[0-9]+');
        /*****************Video sort**************************/
        Route::get('/video/sort','SortController@index');
        Route::get('/video/sort/create','SortController@create');
        Route::post('/video/sort/create','SortController@store');
        Route::get('/video/sort/{id}/edit','SortController@edit')->where('id','[0-9]+');
        Route::delete('/video/sort/{id}','SortController@destroy')->where('id','[0-9]+');
        /*****************Video sort**************************/
        Route::get('/video/tags','TagsController@index');
        Route::post('/video/tag','TagsController@store');
        Route::get('/video/tag/{id}','TagsController@edit');
        Route::delete('/video/tag/{id}','TagsController@destroy');
        /*****************Video**************************/
        Route::get('/video/{status}','VideoController@index')->where('status','[0-9]+');
        Route::get('/video/create','VideoController@create');
        Route::get('/video/import','VideoController@importFile');
        Route::post('/video/import','VideoController@openFile');
        Route::get('/video/search','VideoController@search');
        Route::post('/video/create','VideoController@store');
        Route::post('/video/update','VideoController@update');
        Route::put('/video/updateStatus','VideoController@updateStatus');
        Route::get('/video/{id}/edit','VideoController@edit')->where('id','[0-9]+');
        Route::delete('/video/{id}','VideoController@destroy')->where('id','[0-9]+');
        /*****************Links**************************/
        Route::get('/links','LinkController@index');
        Route::post('/link','LinkController@store');
        Route::get('/link/{id}','LinkController@show');
        Route::delete('/link/{id}','LinkController@destroy');
        /*****************Program**************************/
        Route::get('/program','ProgramController@index');
        Route::get('/program/create','ProgramController@create');
        Route::post('/program/create','ProgramController@store');
        Route::get('/program/{id}/edit','ProgramController@edit');
        Route::delete('/program/{id}','ProgramController@destroy');
        /*****************Point**************************/
        Route::get('/point','PointController@index');
        Route::get('/point/create','PointController@create');
        Route::post('/point/create','PointController@store');
        Route::get('/point/{id}/edit','PointController@edit')->where('id','[0-9]+');
        Route::delete('/point/{id}','PointController@destroy')->where('id','[0-9]+');
        /*****************Pay-Code**************************/
        Route::get('/pay-code/{status}/{point}','PayCodeController@index')->where('status','[0-9]+');
        Route::post('/pay-code','PayCodeController@store');
        Route::delete('/pay-code/{id}','PayCodeController@destroy')->where('id','[0-9]+');
        Route::get('/pay-code/search','PayCodeController@search');
        /*****************Reflect**************************/
        Route::get('/reflect','ReflectController@index');
        /*****************User**************************/
        Route::get('/user','UserController@index');
    });

});

