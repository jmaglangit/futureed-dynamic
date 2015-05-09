<?php

//student login
Routes::post('/student/login/username','Api\v1\StudentLoginController@login');
Routes::post('/student/login/image','Api\v1\StudentLoginController@imagePassword');
Routes::post('/student/login/password','Api\v1\StudentLoginController@loginPassword');

//student password
Routes::get('/student/password/image','Api\v1\StudentPasswordController@getPasswordImages');
Routes::post('/student/password/reset','Api\v1\StudentPasswordController@passwordReset');
Routes::post('/student/password/code','Api\v1\StudentPasswordController@confirmResetCode');
Routes::post('/student/password/new','Api\v1\StudentPasswordController@confirmNewImagePassword');
Routes::post('/student/password/{id}','Api\v1\StudentPasswordController@changeImagePassword');
Routes::post('/student/password/confirm/{id}','Api\v1\StudentPasswordController@confirmPassword');


//student registration
Routes::post('/student/register','Api\v1\StudentRegistrationController@register');
Routes::post('/student/invite','Api\v1\StudentRegistrationController@invite');

//Student
Routes::resource('/student', 'Api\v1\StudentController',
    ['except' => ['create', 'edit']]);


//email
Routes::put('/student/email/{id}','Api\v1\EmailController@updateStudentEmail');
Routes::post('/student/resend/email','Api\v1\EmailController@resendChangeEmail');
Routes::post('/student/confirmation/email','Api\v1\EmailController@confirmChangeEmail');
