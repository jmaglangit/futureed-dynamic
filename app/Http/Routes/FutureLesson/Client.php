<?php
	Routes::group(['prefix' => '/client'], function()
	{
		Routes::get('/', 'FutureLesson\Client\LoginController@index');
		
		Routes::get('/password/forgot', [
			'as' => 'client.password.reset'
			, 'uses' =>'FutureLesson\Client\LoginController@forgot_password'
			]);
		Routes::get('/register/confirm', [
			'as' => 'client.login.confirm'
			, 'uses' => 'FutureLesson\Client\LoginController@enter_confirmation'
		]);
		Routes::get('/registration', [
			'as' => 'client.registration'
			, 'uses' => 'FutureLesson\Client\LoginController@registration'
		]);

		Routes::get('/logout', [ 
			'as' => 'client.logout'
			, 'middleware' => 'client'
			, 'uses' => 'FutureLesson\Client\LoginController@logout'
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
			Routes::post('/process', [ 
				'as' => 'client.login.process'
				, 'uses' => 'FutureLesson\Client\LoginController@process'
			]);
		});

		Routes::group(['prefix' => '/dashboard'], function()
		{
			Routes::get('/', [ 
					'as' => 'client.dashboard.index'
					, 'middleware' => 'client'
					, 'uses' => 'FutureLesson\Client\DashboardController@index'
				]);
			
		});

		Routes::group(['prefix' => '/profile'
					, 'middleware' => 'client'], function()
		{
			Routes::get('/', [ 
					'as' => 'client.profile.index'
					, 'uses' => 'FutureLesson\Client\ProfileController@index'
				]);
			Routes::get('/change-password', [ 
					'as' => 'client.profile.change_password'
					, 'uses' => 'FutureLesson\Client\ProfileController@changePassword'
				]);

			Routes::group(['prefix' => '/partials'], function() {
				Routes::get('/index_form', [
					'as' => 'client.profile.partial.index_form'
					, 'uses' => 'FutureLesson\Client\ProfileController@index_form'
				]);
				Routes::get('/edit_email_form', [
					'as' => 'client.profile.partial.edit_email_form'
					, 'uses' => 'FutureLesson\Client\ProfileController@edit_email_form'
					]);
				Routes::get('/confirm_email_form', [
					'as' => 'client.profile.partial.confirm_email_form'
					, 'uses' => 'FutureLesson\Client\ProfileController@confirm_email_form'
					]);
				Routes::get('/change_password_form', [
					'as' => 'client.profile.partial.change_password_form'
					, 'uses' => 'FutureLesson\Client\ProfileController@change_password_form'
				]);
			});
		});

		Routes::group(['prefix' => 'partials'], function() {
			Routes::get('/base_url', [
					'as' => 'client.partials.base_url'
					, 'uses' => 'FutureLesson\Client\LoginController@base_url'
				]);
			Routes::get('/registration_form', [
					'as' => 'client.partials.registration_form'
					, 'uses' => 'FutureLesson\Client\LoginController@registration_form' 
				]);
			Routes::get('/registration_success', [
					'as' => 'client.partials.registration_success'
					, 'uses' => 'FutureLesson\Client\LoginController@registration_success' 
				]);
		});
	});
	
?>