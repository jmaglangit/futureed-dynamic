<?php

Routes::group(['prefix' => '/student'], function()
{
    //student password
    Routes::post('/password/new','Api\v1\StudentPasswordController@confirmNewImagePassword');

    //authenticated student routes
    Routes::group(['middleware' => 'api_user'],function(){

        //student password
        Routes::get('/password/image','Api\v1\StudentPasswordController@getPasswordImages');
        Routes::post('/password/reset','Api\v1\StudentPasswordController@passwordReset');
        Routes::post('/password/code','Api\v1\StudentPasswordController@confirmResetCode');
        Routes::post('/password/{id}','Api\v1\StudentPasswordController@changeImagePassword');
        Routes::post('/password/confirm/{id}','Api\v1\StudentPasswordController@confirmPassword');

        //email
        Routes::put('/email/{id}','Api\v1\EmailController@updateStudentEmail');
        Routes::post('/confirmation/email','Api\v1\EmailController@confirmChangeEmail');

    });



    //student login
    Routes::post('/login/username','Api\v1\StudentLoginController@login');
    Routes::post('/login/image','Api\v1\StudentLoginController@imagePassword');
    Routes::post('/login/password',[
        'uses' => 'Api\v1\StudentLoginController@loginPassword',
        'as' => 'api.v1.student.login.password',
        'middleware' => 'api_after',
    ]);



    //student registration
    Routes::post('/register','Api\v1\StudentRegistrationController@register');

    //student registration
    Routes::post('/invite','Api\v1\StudentRegistrationController@invite');

    //email
    Routes::post('/resend/email/{id}','Api\v1\EmailController@resendChangeEmail');

});


//authenticated students
Routes::group(['middleware' => 'api_user','permission' => ['admin','user','student']],function(){

    Routes::resource('/student', 'Api\v1\StudentController',
        ['except' => ['create', 'edit']]);

    Routes::resource('/admin/manage/student', 'Api\v1\AdminStudentController',
        ['except' => ['create', 'edit']]);
});
