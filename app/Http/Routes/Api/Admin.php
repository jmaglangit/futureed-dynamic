<?php 

Routes::group(['prefix' => '/admin'], function()
{

	Routes::post('/login','Api\v1\AdminLoginController@login');
	Routes::post('/password/{id}','Api\v1\AdminPasswordController@changePassword');

	//Admin add client 
	Routes::post('/client/register','Api\v1\AdminClientController@addClient');

	Routes::resource('/client', 'Api\v1\AdminClientController',
    ['except' => ['create', 'edit']]);

});

Routes::resource('/admin','Api\v1\AdminController',
    ['except' => ['create', 'edit']]);
