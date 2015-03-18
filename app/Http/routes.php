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

//TODO: Drill down routing into directory.

include('Routes/Frontage/frontage.php');

$router->resource('admin','AdminController');
$router->resource('dashboard','DashboardController');
$router->resource('student','StudentController');


Routes::group(['prefix' => 'api/v1'], function()
{
    //student login
    Routes::post('/students/login/username','Api\v1\StudentsLoginController@login');
    Routes::post('/students/login/image','Api\v1\StudentsLoginController@imagePassword');
    Routes::post('/students/login/password','Api\v1\StudentsLoginController@password');
    //student password
    Routes::post('/students/password/reset','Api\v1\StudentsLoginController@resetPassword');
    Routes::post('/students/password/forgot','Api\v1\StudentsLoginController@forgotPassword');
    Routes::post('/students/password/image','Api\v1\StudentsLoginController@images');
    //student registration
    Routes::post('/students/registration/email','Api\v1\StudentsRegistrationController@checkEmail');
    Routes::post('/students/registration/username','Api\v1\StudentsRegistrationController@checkUserName');
    Routes::post('/students/registration','Api\v1\StudentsRegistrationController@add');
    //schools
    Routes::get('/schools','Api\v1\SchoolsController@schools');
    //

});
