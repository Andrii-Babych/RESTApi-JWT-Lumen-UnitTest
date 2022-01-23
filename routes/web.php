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


$router->group(['prefix' => 'api/user'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/sign-in', 'AuthController@login');
    $router->post('/recover-password','ResetsPasswordsController@generateResetToken');
    $router->patch('/recover-password', [
        'as' => 'password.reset',
        'uses' => 'ResetsPasswordsController@resetPassword'
    ]);

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/logout', 'AuthController@logout');
//        $router->get('/companies', 'CompaniesController@index');
//        $router->post('/companies', 'CompaniesController@store');
    });
});
