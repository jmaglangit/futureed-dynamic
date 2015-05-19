<?php

Routes::group(['prefix' => '/student'], function()
{

    //authenticated student routes
    Routes::group(['middleware' => 'api_student'],function(){

        //student password
        Routes::get('/password/image','Api\v1\StudentPasswordController@getPasswordImages');
        Routes::post('/password/reset','Api\v1\StudentPasswordController@passwordReset');
        Routes::post('/password/code','Api\v1\StudentPasswordController@confirmResetCode');
        Routes::post('/password/new','Api\v1\StudentPasswordController@confirmNewImagePassword');
        Routes::post('/password/{id}','Api\v1\StudentPasswordController@changeImagePassword');
        Routes::post('/password/confirm/{id}','Api\v1\StudentPasswordController@confirmPassword');

        //student registration
        Routes::post('/invite','Api\v1\StudentRegistrationController@invite');

        //email
        Routes::put('/email/{id}','Api\v1\EmailController@updateStudentEmail');
        Routes::post('/confirmation/email','Api\v1\EmailController@confirmChangeEmail');

    });

    //student login
    Routes::post('/login/username','Api\v1\StudentLoginController@login');
    Routes::post('/login/image','Api\v1\StudentLoginController@imagePassword');
    Routes::post('/login/password','Api\v1\StudentLoginController@loginPassword');

    //student registration
    Routes::post('/register','Api\v1\StudentRegistrationController@register');

    //email
    Routes::post('/resend/email/{id}','Api\v1\EmailController@resendChangeEmail');

});


//authenticated students
Routes::group(['middleware' => 'api_student'],function(){

    Routes::resource('/student', 'Api\v1\StudentController',
        ['except' => ['create', 'edit']]);
});
