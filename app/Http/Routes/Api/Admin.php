<?php 

Routes::group(['middleware' => 'api_user','prefix' => '/admin'], function()
{

	Routes::post('/login','Api\v1\AdminLoginController@login');
    
    Routes::post('/change-email/{id}','Api\v1\EmailController@adminChangeEmail');

	Routes::post('/forgot-password/{id}','Api\v1\AdminPasswordController@forgotPassword');

    Routes::post('change-password/{id}','Api\v1\AdminPasswordController@changePassword');


});

Routes::resource('/admin','Api\v1\AdminController',
    ['except' => ['create', 'edit']]);
