<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


/*
Route::post('/upload', function(){
    $url = request()->file('imagem')->store('img/imoveis','s3');
    $urlCompleta = Storage::disk('s3')->url($url);

    var_dump($urlCompleta);
    dd($url);
    die();
});
*/
Auth::routes();

require base_path('routes/web.frontend.php');
require base_path('routes/web.backend.php');



