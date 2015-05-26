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
			$manage_admin_controller = 'FutureLesson\Admin\ManageAdminController';

			Routes::get('/', [
				  'as' => 'admin.manage.admin.index'
				, 'middleware' => 'admin'
				, 'uses' => $manage_admin_controller . '@index'
			]);

			/**
			* admin/manage/admin
			*/
			Routes::group(['prefix' => '/admin'], function() {
				$manage_admin_controller = 'FutureLesson\Admin\ManageAdminController';

				Routes::get('/', [
						'as' => 'admin.manage.admin.index'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@index'
					]);
				
				Routes::group(['prefix' => '/partials'], function(){
					$manage_admin_controller = 'FutureLesson\Admin\ManageAdminController';

					Routes::get('/side_nav', [
						'as' => 'admin.manage.admin.partials.side_nav'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@side_nav'
					]);

					Routes::get('/list_admin_form', [
						  'as' => 'admin.manage.client.partials.list_admin_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@list_admin_form'
					]);

					Routes::get('/add_admin', [
						  'as' => 'admin.manage.client.partials.add_admin'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@add_admin'
					]);
				});
			});

			Routes::group(['prefix' => '/client'], function() {
				$manage_client_controller = 'FutureLesson\Admin\ManageClientController';

				Routes::get('/', [
					  'as' => 'admin.manage.client.index'
					, 'middleware' => 'admin'
					, 'uses' => $manage_client_controller . '@index'
				]);

				Routes::group(['prefix' => 'partials'], function() {
					$manage_client_controller = 'FutureLesson\Admin\ManageClientController';

					Routes::get('/side_nav', [
						  'as' => 'admin.manage.client.partials.side_nav'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@side_nav'
					]);


					Routes::get('/list_client_form', [
						  'as' => 'admin.manage.client.partials.list_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@list_client_form'
					]);

					Routes::get('/add_client_form', [
						  'as' => 'admin.manage.client.partials.add_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@add_client_form'
					]);

					Routes::get('/client_details_form', [
						  'as' => 'admin.manage.client.partials.client_details_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@client_details_form'
					]);

					Routes::get('/edit_email_form', [
						  'as' => 'admin.manage.client.partials.edit_email_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@edit_email_form'
					]);

					Routes::get('/confirm_email_form', [
						  'as' => 'admin.manage.client.partials.confirm_email_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@confirm_email_form'
					]);

					Routes::get('/type_ahead_form', [
						  'as' => 'admin.manage.client.partials.type_ahead_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@type_ahead_form'
					]);
					
				});
			});

			/**
			* admin/manage/price
			*/
			Routes::group(['prefix' => '/price'], function()
				{
					$price_controller = 'FutureLesson\Admin\PriceController';
					Routes::get('/', 
						[
							'as' => 'admin.manage.price.index'
							,'middleware' => 'admin'
							,'uses' => $price_controller. '@index'
						]);
					/**
					* admin/manage/price/partials
					*/
					Routes::group(['prefix' => '/partials'], function()
						{
							$price_controller = 'FutureLesson\Admin\PriceController';
							Routes::get('price_settings',
								[
									'as' => 'admin.manage.price.partials.price_settings'
									, 'middleware' => 'admin'
									, 'uses' => $price_controller . '@price_settings'
								]);
							Routes::get('client_discount',
								[
									'as' => 'admin.manage.price.partials.client_discount'
									, 'middleware' => 'admin'
									, 'uses' => $price_controller . '@client_discount'
								]);
							Routes::get('edit_price',
								[
									'as' => 'admin.manage.price.partials.edit_price'
									, 'middleware' => 'admin'
									, 'uses' => $price_controller . '@edit_price'
								]);
							Routes::get('bulk_discount',
								[
									'as' => 'admin.manage.price.partials.bulk_discount'
									, 'middleware' => 'admin'
									, 'uses' => $price_controller . '@bulk_discount'
								]);
							Routes::get('bulk_edit',
								[
									'as' => 'admin.manage.price.partials.bulk_edit'
									, 'middleware' => 'admin'
									, 'uses' => $price_controller . '@bulk_edit'
								]);
						});
				});

			/**
			* admin/manage/announcement
			*/
			Routes::group(['prefix' => '/announcement'], function()
				{
					$announce_controler = 'FutureLesson\Admin\AnnouncementController';
					Routes::get('/',
						[
							'as' => 'admin.manage.announce.index'
							, 'middleware' => 'admin'
							, 'uses' => $announce_controler. '@index'
						]);
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
