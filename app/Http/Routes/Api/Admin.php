<?php 

Routes::group(['prefix' => '/admin'], function()
{

	Routes::post('/login','Api\v1\AdminLoginController@login');
	Routes::post('/password/{id}','Api\v1\AdminPasswordController@changePassword');

});

Routes::resource('/admin','Api\v1\AdminController',
    ['except' => ['create', 'edit']]);
