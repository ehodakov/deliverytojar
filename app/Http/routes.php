<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('map');
});

Route::get('/order/{order}', function (App\Order $order) {
    if ($car = $order->car) {
        return Response::json([
            'result' => 'ok',
            'location' => $car->location,
            'latitude' => $car->latitude,
            'longitude' => $car->longitude,
        ]);
    }
    return Response::json([
        'result' => 'error'
    ]);
});

Route::auth();

Route::get('/home', 'HomeController@index');
