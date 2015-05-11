<?php 

Routes::group(['prefix' => '/admin'], function()
{

	Routes::post('/login','Api\v1\AdminLoginController@login');
	Routes::post('/password/{id}','Api\v1\AdminPasswordController@changePassword');

});
