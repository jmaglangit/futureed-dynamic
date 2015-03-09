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

//Routes::get('/', 'WelcomeController@index');
//Routes::get('home', 'HomeController@index');
//Route::controllers([
//    'auth' => 'Auth\AuthController',
//    'password' => 'Auth\PasswordController',
//]);

$router->resource('admin','AdminController');
$router->resource('dashboard','DashboardController');
$router->resource('student','StudentController');
$router->resource('student','StudentController');
