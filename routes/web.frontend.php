<?php

Route::group(['namespace' => 'Frontend'], function () {

    Route::get('/home', function () {
        return redirect()->route('backend.home.index');
    });

    Route::get('/', 'HomeController@index')->name('frontend.home.index');
    Route::get('/imovel/{imovel}', 'HomeController@show')->name('frontend.home.show');

});