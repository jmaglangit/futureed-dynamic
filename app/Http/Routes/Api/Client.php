<?php

Routes::group(['middleware' => 'api_user','prefix' => '/client'], function()
{

    //Parent
    Routes::resource('/parent','Api\v1\ClientParentController',
        ['except' => ['create','edit']]);
    Routes::get('/parent/student/list/{id}','Api\v1\ClientParentController@getStudentList');

    //Principal
    Routes::resource('/principal','Api\v1\ClientPrincipalController',
        ['except' => ['create','edit']]);

    //Teacher
    Routes::resource('/teacher','Api\v1\ClientTeacherController',
        ['except' => ['create','edit']]);

	Routes::get('/teacher-information/{id}',[
		'as' => 'api.v1.client.teacher.information',
		'uses' => 'Api\v1\ClientTeacherRegistrationController@getTeacherInformation'
	]);

    //client
    Routes::post('/login','Api\v1\ClientLoginController@login');
    Routes::post('/register','Api\v1\ClientRegisterController@register');
    Routes::post('/reset-password/{id}','Api\v1\ClientPasswordController@resetPassword');
    Routes::post('/change-password/{id}','Api\v1\ClientPasswordController@changePassword');
    Routes::post('/new-password/{id}','Api\v1\ClientPasswordController@setPassword');

    //change email in client
    Routes::post('/change-email/{id}','Api\v1\EmailController@updateClientEmail');
    Routes::post('/resend-email/{id}','Api\v1\EmailController@resendChangeEmail');
    Routes::post('/update-email/{id}','Api\v1\EmailController@confirmChangeEmail');

    //for verification via admin
    Routes::post('/verify-client/{id}','Api\v1\EmailController@verifyClient');

    //reject client 
     Routes::post('/reject-client/{id}','Api\v1\EmailController@rejectClient');

     //set status for client
     Routes::post('/change-status/{id}','Api\v1\AdminClientController@setClientStatus');

});


//Client
Routes::group(['middleware' => 'api_user'],function(){
    Routes::resource('/client','Api\v1\ClientController',
        ['except' => ['create','edit']]);

    Routes::get('client/custom/view-details/','Api\v1\ClientCustomController@getClient');
});
