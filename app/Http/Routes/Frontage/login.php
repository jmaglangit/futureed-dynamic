<?php
	
	Routes::get('/', 'Frontage\LoginController@index');
	
	Routes::group(['prefix' => '/login'], function()
	{
		Routes::get('/', [ 'as' => 'login', 'uses' => 'Frontage\LoginController@index']);
		Routes::get('/forgot-password', [ 'as' => 'login.forgot_password', 'uses' => 'Frontage\LoginController@forgot_password']);
		Routes::get('/forgot-password-success', [ 'as' => 'login.forgot_password_success', 'uses' => 'Frontage\LoginController@forgot_password_success']);
		Routes::get('/reset-password', [ 'as' => 'login.reset_password', 'uses' => 'Frontage\LoginController@reset_password']);
		Routes::get('/reset-password-success', [ 'as' => 'login.reset_password_success', 'uses' => 'Frontage\LoginController@reset_password_success']);
		
	});
	
	Routes::get('/registration', 'Frontage\LoginController@registration');
	Routes::get('/registration-success', 'Frontage\LoginController@registration_success');
	
?>