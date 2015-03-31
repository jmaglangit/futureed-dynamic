<?php
	
	Routes::get('/', 'FutureLesson\Client\LoginController@index');
	
	
	Routes::group(['prefix' => '/client'], function()
	{
		Routes::group(['prefix' => '/login'], function()
		{
			Routes::get('/', [ 'as' => 'client.login', 'uses' => 'FutureLesson\Client\LoginController@index']);
			Routes::get('/forgot-password', [ 'as' => 'client.login.forgot_password', 'uses' => 'FutureLesson\Client\LoginController@forgot_password']);
			Routes::get('/forgot-password-success', [ 'as' => 'client.login.forgot_password_success', 'uses' => 'FutureLesson\Client\LoginController@forgot_password_success']);
			Routes::get('/reset-password', [ 'as' => 'client.login.reset_password', 'uses' => 'FutureLesson\Client\LoginController@reset_password']);
			Routes::get('/reset-password-success', [ 'as' => 'client.login.reset_password_success', 'uses' => 'FutureLesson\Client\LoginController@reset_password_success']);
			
		});
		
		Routes::get('/registration', ['as' => 'client.registration', 'users' => 'FutureLesson\Client\LoginController@registration']);
		Routes::get('/registration-success', ['as' => 'client.registration-success', 'users' => 'FutureLesson\Client\LoginController@registration_success']);
	});
	
?>