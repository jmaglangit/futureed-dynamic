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
    Routes::post('/input','Api\v1\TokenController@input');


    Routes::get('/','Api\v1\ApiController@index');

    //users
    Routes::get('/user','Api\v1\UserController@index');
    Routes::post('/user/password/reset','Api\v1\UserPasswordController@passwordReset');
    Routes::post('/user/password/forgot','Api\v1\UserPasswordController@passwordForgot');
    Routes::post('/user/password/code', 'Api\v1\UserPasswordController@confirmResetCode');
    Routes::post('/user/email','Api\v1\EmailController@checkEmail');
    Routes::post('/user/username','Api\v1\UserController@checkUser');
    Routes::post('/user/email/code','Api\v1\UserController@confirmEmailCode');

    //student login
    Routes::post('/student/login/username','Api\v1\StudentLoginController@login');
    Routes::post('/student/login/image','Api\v1\StudentLoginController@imagePassword');
    Routes::post('/student/login/password','Api\v1\StudentLoginController@password');

    //student password
    Routes::get('/student/password/image','Api\v1\StudentPasswordController@getPasswordImages');
    Routes::post('/student/password/reset','Api\v1\StudentPasswordController@passwordReset');
    Routes::post('/student/password/code','Api\v1\StudentPasswordController@confirmResetCode');
    Routes::post('/student/password/new','Api\v1\StudentPasswordController@confirmNewImagePassword');
    Routes::post('/student/password/{id}','Api\v1\StudentPasswordController@changeImagePassword');
    
    //student registration
    Routes::post('/student/register','Api\v1\StudentRegistrationController@register');
    Routes::post('/student/invite','Api\v1\StudentRegistrationController@invite');

    //Student
	Routes::resource('/student', 'Api\v1\StudentController',
					['except' => ['create', 'edit']]);

    //Client
    Routes::resource('/client','Api\v1\ClientController',
                    ['except' => ['create','edit']]);

    //Parent
    Routes::resource('/client/parent','Api\v1\ClientParentController',
                    ['except' => ['create','edit']]);
    Routes::get('client/parent/student/list/{id}','Api\v1\ClientParentController@getStudentList');

    //Principal
    Routes::resource('/client/principal','Api\v1\ClientPrincipalController',
                    ['except' => ['create','edit']]);

    //Teacher
    Routes::resource('/client/teacher','Api\v1\ClientTeacherController',
                    ['except' => ['create','edit']]);

    //grade
    Routes::resource('/grade','Api\v1\GradeController',
                    ['except' => ['create','edit']]);

    //schools
    Routes::resource('/school','Api\v1\SchoolController',
                    ['except' => ['create','edit']]);
    
    
    //avatars
    Routes::post('/user/avatar','Api\v1\AvatarController@selectAvatars');
    Routes::post('/user/avatar/new','Api\v1\AvatarController@saveUserAvatar');

    //client
    Routes::post('/client/login','Api\v1\ClientLoginController@login');
<<<<<<< HEAD
    Routes::post('/client/register','Api\v1\ClientRegisterController@register');
=======

    //countries
    Routes::resource('/countries','Api\v1\CountryController',
        ['except' => ['create','edit']]);


>>>>>>> 279606cb04ade4caf77e5867f2daafdd3eddb7d6



});
