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

include('Routes/FutureLesson/Futurelesson.php');


Routes::group(['prefix' => 'api/v1'], function()
{
    Routes::get('/','Api\v1\ApiController@index');

		include('Routes/Api/Admin.php');
		include('Routes/Api/Announcement.php');
        include('Routes/Api/Client.php');
        include('Routes/Api/ClientDiscount.php');
        include('Routes/Api/Countries.php');
        include('Routes/Api/Grade.php');
        include('Routes/Api/School.php');
        include('Routes/Api/Student.php');
        include('Routes/Api/Subject.php');
        include('Routes/Api/Subscription.php');
        include('Routes/Api/User.php');
//    //users
//    Routes::get('/user','Api\v1\UserController@index');
//    Routes::post('/user/password/reset','Api\v1\UserPasswordController@passwordReset');
//    Routes::post('/user/password/forgot','Api\v1\UserPasswordController@passwordForgot');
//    Routes::post('/user/password/code', 'Api\v1\UserPasswordController@confirmResetCode');
//    Routes::post('/user/email','Api\v1\EmailController@checkEmail');
//    Routes::post('/user/username','Api\v1\UserController@checkUser');
//    Routes::post('/user/email/code','Api\v1\UserController@confirmEmailCode');
//    Routes::post('/user/reset/code', 'Api\v1\UserController@resendResetEmailCode');
//    Routes::post('/user/confirmation/code', 'Api\v1\UserController@resendRegisterEmailCode');


//    //student login
//    Routes::post('/student/login/username','Api\v1\StudentLoginController@login');
//    Routes::post('/student/login/image','Api\v1\StudentLoginController@imagePassword');
//    Routes::post('/student/login/password','Api\v1\StudentLoginController@loginPassword');
//
//    //student password
//    Routes::get('/student/password/image','Api\v1\StudentPasswordController@getPasswordImages');
//    Routes::post('/student/password/reset','Api\v1\StudentPasswordController@passwordReset');
//    Routes::post('/student/password/code','Api\v1\StudentPasswordController@confirmResetCode');
//    Routes::post('/student/password/new','Api\v1\StudentPasswordController@confirmNewImagePassword');
//    Routes::post('/student/password/{id}','Api\v1\StudentPasswordController@changeImagePassword');
//    Routes::post('/student/password/confirm/{id}','Api\v1\StudentPasswordController@confirmPassword');
//
//
//    //student registration
//    Routes::post('/student/register','Api\v1\StudentRegistrationController@register');
//    Routes::post('/student/invite','Api\v1\StudentRegistrationController@invite');
//
//    //Student
//	Routes::resource('/student', 'Api\v1\StudentController',
//					['except' => ['create', 'edit']]);

//    //Client
//    Routes::resource('/client','Api\v1\ClientController',
//                    ['except' => ['create','edit']]);
//
//    //Parent
//    Routes::resource('/client/parent','Api\v1\ClientParentController',
//                    ['except' => ['create','edit']]);
//    Routes::get('client/parent/student/list/{id}','Api\v1\ClientParentController@getStudentList');
//
//    //Principal
//    Routes::resource('/client/principal','Api\v1\ClientPrincipalController',
//                    ['except' => ['create','edit']]);
//
//    //Teacher
//    Routes::resource('/client/teacher','Api\v1\ClientTeacherController',
//                    ['except' => ['create','edit']]);

//    //grade
//    Routes::resource('/grade','Api\v1\GradeController',
//                    ['except' => ['create','edit']]);

//    //schools
//    Routes::resource('/school','Api\v1\SchoolController',
//                    ['except' => ['create','edit']]);
    
    
//    //avatars
//    Routes::post('/user/avatar','Api\v1\AvatarController@selectAvatars');
//    Routes::post('/user/avatar/new','Api\v1\AvatarController@saveUserAvatar');

//    //client
//    Routes::post('/client/login','Api\v1\ClientLoginController@login');
//    Routes::post('/client/register','Api\v1\ClientRegisterController@register');
//    Routes::post('/client/password/{id}','Api\v1\ClientPasswordController@changePassword');

//    //countries
//    Routes::resource('/countries','Api\v1\CountryController',
//        ['except' => ['create','edit']]);

//    //email
//    Routes::put('/student/email/{id}','Api\v1\EmailController@updateStudentEmail');
//    Routes::post('/student/resend/email','Api\v1\EmailController@resendChangeEmail');
//    Routes::post('/student/confirmation/email','Api\v1\EmailController@confirmChangeEmail');



  





});
