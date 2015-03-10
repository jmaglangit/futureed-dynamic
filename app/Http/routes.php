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

Routes::get('/','DashboardController@index');
$router->resource('admin','AdminController');
$router->resource('dashboard','DashboardController');
$router->resource('student','StudentController');

Routes::group(['prefix' => 'api/v1'], function()
{
    //student login
    Routes::get('/students/login/1/{email}','Api\v1\StudentsLoginController@email');
    Routes::get('/students/login/2/{id}/{password}','Api\v1\StudentsLoginController@password');
    Routes::get('/students/login/2/image/{id}','Api\v1\StudentsLoginController@imagePassword');
    //student registration

});
