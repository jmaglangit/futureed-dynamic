<?php 
	Routes::group(['prefix' => '/admin'], function()
	{
		Routes::get('/', 'FutureLesson\Admin\LoginController@index');
		Routes::get('/password/forgot',[
				'as' => 'admin.password.reset'
				, 'uses' => 'FutureLesson\Admin\LoginController@forgotPass'
			]);
		Routes::get('/base_url',[
				'as' => 'admin.base_url'
				, 'uses' => 'FutureLesson\Admin\LoginController@base_url'
			]);
		
		Routes::get('/logout', [ 
			'as' => 'admin.logout'
			, 'middleware' => 'admin'
			, 'uses' => 'FutureLesson\Admin\LoginController@logout'
		]);

		Routes::group(['prefix' => '/login'], function()
		{
			Routes::get('/', [
					'as' => 'admin.login'
					, 'uses' => 'FutureLesson\Admin\LoginController@index'
				]);
			Routes::get('/forgot-password', [
					'as' => 'admin.login.forgot_password'
					, 'uses' => 'FutureLesson\Admin\LoginController@forgotPass'
				]);
			/*change this to post (for template viewing only)*/
			Routes::post('/reset-password', [
					'as' => 'admin.login.reset_password'
					, 'uses' => 'FutureLesson\Admin\LoginController@resetPass'
				]);
			Routes::post('/process', [
					'as' => 'admin.login.process'
					, 'uses' => 'FutureLesson\Admin\LoginController@process'
				]);
		});

		Routes::group(['prefix' => '/manage'] , function() {
			Routes::get('/', [
				'as' => 'admin.manage.index'
				, 'middleware' => 'admin'
				, 'uses' => 'FutureLesson\Admin\DashboardController@index'
			]);

			Routes::group(['prefix' => '/client'], function() {
				$client_controller = 'FutureLesson\Admin\ClientController';

				Routes::get('/', [
					  'as' => 'admin.manage.client.index'
					, 'middleware' => 'admin'
					, 'uses' => $client_controller . '@index'
				]);

				Routes::group(['prefix' => 'partials'], function() {
					$client_controller = 'FutureLesson\Admin\ClientController';

					Routes::get('/side_nav', [
						  'as' => 'admin.manage.client.partials.side_nav'
						, 'middleware' => 'admin'
						, 'uses' => $client_controller . '@side_nav'
					]);

					Routes::get('/list_client_form', [
						  'as' => 'admin.manage.client.partials.list_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $client_controller . '@list_client_form'
					]);

					Routes::get('/add_client_form', [
						  'as' => 'admin.manage.client.partials.add_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $client_controller . '@add_client_form'
					]);

					Routes::get('/edit_email_form', [
						  'as' => 'admin.manage.client.partials.edit_email_form'
						, 'middleware' => 'admin'
						, 'uses' => $client_controller . '@edit_email_form'
					]);

					Routes::get('/confirm_email_form', [
						  'as' => 'admin.manage.client.partials.confirm_email_form'
						, 'middleware' => 'admin'
						, 'uses' => $client_controller . '@confirm_email_form'
					]);
				});
			});
		});

		Routes::group(['prefix' => '/dashboard'], function()
		{
			Routes::get('/', [
					'as' => 'admin.dashboard.index'
					, 'middleware' => 'admin'
					, 'uses' => 'FutureLesson\Admin\DashboardController@index'
				]);
			Routes::get('/client_list', [
					'as' => 'admin.dashboard.client_list'
					, 'uses' => 'FutureLesson\Admin\DashboardController@client_list'
				]);
			Routes::get('/add_client', [
					'as' => 'admin.dashboard.add_client'
					, 'uses' => 'FutureLesson\Admin\DashboardController@add_client'
				]);
			Routes::get('/announcement', [
					'as' => 'admin.dashboard.announcement'
					, 'uses' => 'FutureLesson\Admin\DashboardController@announcement'
				]);
		});

		Routes::group(['prefix' => 'partials'], function() {
			Routes::get('/base_url', [
					'as' => 'admin.partials.base_url'
					, 'uses' => 'FutureLesson\Admin\LoginController@base_url'
				]);
		});
	});
?>
