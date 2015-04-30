<?php
	Routes::get('/', 'FutureLesson\Client\LoginController@index');

	Routes::group(['prefix' => '/client'], function()
	{
		Routes::get('/', 'FutureLesson\Client\LoginController@index');
		Routes::get('/password/reset', [
			'as' => 'client.password.reset'
			, 'uses' =>'FutureLesson\Client\LoginController@forgot_password'
			]);
		Routes::get('/email/confirm', [
			'as' => 'client.login.confirm'
			, 'uses' => 'FutureLesson\Client\LoginController@registration'
		]);
		Routes::get('/registration', [
				'as' => 'client.registration'
				, 'uses' => 'FutureLesson\Client\LoginController@registration'
			]);

		Routes::group(['prefix' => '/login'], function()
		{
			Routes::get('/', [ 
					'as' => 'client.login'
					, 'uses' => 'FutureLesson\Client\LoginController@index'
				]);
			Routes::get('/forgot-password', [ 
					'as' => 'client.login.forgot_password'
					, 'uses' => 'FutureLesson\Client\LoginController@forgot_password'
				]);
			Routes::post('/reset-password', [ 
					'as' => 'client.login.reset_password'
					, 'uses' => 'FutureLesson\Client\LoginController@reset_password'
				]);
			
		});

		Routes::group(['prefix' => '/dashboard'], function()
		{
			Routes::get('/', [ 
					'as' => 'client.dashboard'
					, 'uses' => 'FutureLesson\Client\DashboardController@index'
				]);
			
		});
	});
	
?>