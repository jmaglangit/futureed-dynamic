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

include('Routes/FutureLesson/futurelesson.php');


Routes::group(['prefix' => 'api/v1'], function()
{
    //token routes to be remove after test
    Routes::get('/code','Api\v1\TokenController@getCode');
    Routes::get('/sendmail','Api\v1\TokenController@sendMail');


    Routes::get('/','Api\v1\ApiController@index');

    //users
    Routes::get('/user','Api\v1\UserController@index');
    Routes::post('/user/password/reset','Api\v1\UserPasswordController@passwordReset');
    Routes::post('/user/password/forgot','Api\v1\UserPasswordController@passwordForgot');
    Routes::post('/user/password/code', 'Api\v1\UserPasswordController@confirmResetCode');
    Routes::post('/user/email','Api\v1\EmailController@checkEmail');
    Routes::post('/user/username','Api\v1\UserController@checkUser');

    //student login
    Routes::post('/student/login/username','Api\v1\StudentsLoginController@login');
    Routes::post('/student/login/image','Api\v1\StudentsLoginController@imagePassword');
    Routes::post('/student/login/password','Api\v1\StudentsLoginController@password');

    //student password
    Routes::get('/student/password/image','Api\v1\StudentsPasswordController@getPasswordImages');
    Routes::post('/student/password/reset','Api\v1\StudentsPasswordController@passwordReset');
    Routes::post('/student/password/code','Api\v1\StudentsPasswordController@confirmResetCode');
    Routes::post('/student/password/new','Api\v1\StudentsPasswordController@confirmNewImagePassword');
    
    //student registration
    Routes::post('/student/register','Api\v1\StudentsRegistrationController@register');
    Routes::post('/student/invite','Api\v1\StudentsRegistrationController@invite');
    

    //schools
    Routes::get('/school','Api\v1\SchoolsController@schools');
    
    
    //avatars
    Routes::post('user/avatar','Api\v1\AvatarController@selectAvatars');


});
