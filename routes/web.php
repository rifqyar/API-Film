<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function() use ($router){
    $router->get('get-token', 'TokenController@getToken');
    $router->get('check-token', 'TokenController@cekToken');

    $router->group(['middleware' => 'jwt.auth'], function() use ($router){
        $router->group(['prefix' => 'movies'], function() use ($router){
            $router->get('/', 'FilmController@index');
            $router->get('/{id}', 'FilmController@show');
            $router->post('/', 'FilmController@store');
            $router->put('/{id}', 'FilmController@update');
            $router->delete('/{id}', 'FilmController@delete');
        });
    });
});
