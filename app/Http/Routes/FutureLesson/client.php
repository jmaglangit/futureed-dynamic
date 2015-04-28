<?php
	Routes::get('/', 'FutureLesson\Client\LoginController@index');

	Routes::group(['prefix' => '/client'], function()
	{
		Routes::get('/', 'FutureLesson\Client\LoginController@index');

		Routes::group(['prefix' => '/login'], function()
		{
			Routes::get('/', [ 'as' => 'client.login', 'uses' => 'FutureLesson\Client\LoginController@index']);
			Routes::get('/forgot-password', [ 'as' => 'client.login.forgot_password', 'uses' => 'FutureLesson\Client\LoginController@forgot_password']);
			Routes::post('/reset-password', [ 'as' => 'client.login.reset_password', 'uses' => 'FutureLesson\Client\LoginController@reset_password']);
			
		});
		
		Routes::get('/registration', ['as' => 'client.registration', 'uses' => 'FutureLesson\Client\LoginController@registration']);
		Routes::get('/registration-success', ['as' => 'client.registration-success', 'uses' => 'FutureLesson\Client\LoginController@registration_success']);
	});
	
?>