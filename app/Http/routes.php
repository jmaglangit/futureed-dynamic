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

//TODO: Drill down routing into directory.

Routes::get('/','DashboardController@index');
$router->resource('admin','AdminController');
$router->resource('dashboard','DashboardController');
$router->resource('student','StudentController');


Routes::group(['prefix' => 'api/v1'], function()
{
    Routes::get('/','Api\v1\ApiController@index');
    //users
    Routes::get('/user','Api\v1\UserController@index');
    //student login
    Routes::post('/student/login/username','Api\v1\StudentsLoginController@login');
    Routes::post('/student/login/image','Api\v1\StudentsLoginController@imagePassword');
    Routes::post('/student/login/password','Api\v1\StudentsLoginController@password');
    //student password
    Routes::post('/student/password/reset','Api\v1\StudentsLoginController@resetPassword');
    Routes::post('/student/password/forgot','Api\v1\StudentsLoginController@forgotPassword');
    Routes::post('/student/password/image','Api\v1\StudentsLoginController@images');
    //student registration
    Routes::post('/student/registration/email','Api\v1\StudentsRegistrationController@checkEmail');
    Routes::post('/student/registration/username','Api\v1\StudentsRegistrationController@checkUserName');
    Routes::post('/student/registration','Api\v1\StudentsRegistrationController@add');
    //schools
    Routes::get('/school','Api\v1\SchoolsController@schools');
    //



});
