<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('backend.home.index');


    Route::get('/imovel', 'ImovelController@index')->name('backend.imovel.index');
    Route::get('/imovel/create', 'ImovelController@create')->name('backend.imovel.create');
    Route::post('/imovel', 'ImovelController@store')->name('backend.imovel.store');
    Route::get('/imovel/{imovel}', 'ImovelController@show')->name('backend.imovel.show');
    Route::get('/imovel/{imovel}/edit', 'ImovelController@edit')->name('backend.imovel.edit');
    Route::put('/imovel/{imovel}', 'ImovelController@update')->name('backend.imovel.update');
    Route::delete('/imovel/{imovel}', 'ImovelController@destroy')->name('backend.imovel.destroy');

});
