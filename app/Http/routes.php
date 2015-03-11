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
    Routes::post('/students/login/1','Api\v1\StudentsLoginController@login');
    Routes::post('/students/login/2/images','Api\v1\StudentsLoginController@imagePassword');
    Routes::post('/students/login/2','Api\v1\StudentsLoginController@password');
    //student registration
    Routes::post('/students/registration/email','Api\v1\StudentsRegistrationController@checkEmail');
    Routes::post('/students/registration/username','Api\v1\StudentsRegistrationController@checkUserName');
    //schools
    Routes::get('/schools','Api\v1\SchoolsController@schools');



});
