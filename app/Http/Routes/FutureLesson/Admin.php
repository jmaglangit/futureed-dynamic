<?php 
	Routes::group(['prefix' => '/peaches'], function()
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
						  'as' => 'admin.manage.admin.partials.list_admin_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@list_admin_form'
					]);

					Routes::get('/add_admin', [
						  'as' => 'admin.manage.admin.partials.add_admin'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@add_admin'
					]);
					Routes::get('/view_admin', [
						  'as' => 'admin.manage.admin.partials.view_admin'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@view_admin'
					]);
					Routes::get('/reset_pass', [
						  'as' => 'admin.manage.admin.partials.reset_pass'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@reset_pass'
					]);
					Routes::get('/edit_email_form', [
						  'as' => 'admin.manage.admin.partials.edit_email_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@edit_email_form'
					]);
					Routes::get('/delete_admin_form', [
						  'as' => 'admin.manage.admin.partials.delete_admin_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@delete_admin_form'
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

					Routes::get('/delete_client_form', [
						  'as' => 'admin.manage.client.partials.delete_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@delete_client_form'
					]);
				});
			});
			
			/**
			*STUDENT Routes
			*/
			Routes::group(['prefix' => '/student'], function(){
				$manage_student_controller = 'FutureLesson\Admin\ManageStudentController';

				Routes::get('/',
					[
						'as' => 'admin.manage.student.index'
						, 'middleware' => 'admin'
						, 'uses' => $manage_student_controller . '@index'
					]);
				Routes::group(['prefix' => '/partials'], function(){
					$manage_student_controller = 'FutureLesson\Admin\ManageStudentController';

					Routes::get('/list_student_form',
						[
							'as' => 'admin.manage.student.partials.list_student_form'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@list_student_form'
						]);
					Routes::get('/add_student_form',
						[
							'as' => 'admin.manage.student.partials.add_student_form'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@add_student_form'
						]);
					Routes::get('/view_student_form',
						[
							'as' => 'admin.manage.student.partials.view_student_form'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@view_student_form'
						]);
					Routes::get('/delete_student_form',
						[
							'as' => 'admin.manage.student.partials.delete_student_form'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@delete_student_form'
						]);
				});
			});

			/**
			* CRUD Subject Routes
			*/
			Routes::group(['prefix' => '/subject'], function() {
				
				$subject_controller = 'FutureLesson\Admin\ManageSubjectController';
				
				Routes::get('/',
					[
						'as' => 'admin.manage.subject.index'
						, 'middleware' => 'admin'
						, 'uses' => $subject_controller . '@index'
					]);

				Routes::group(['prefix' => '/partial'], function() {
					$subject_controller = 'FutureLesson\Admin\ManageSubjectController';

					Routes::get('/subject_list_form',
						[
							'as' => 'admin.manage.subject.partials.subject_list_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_list_form'
						]);

					Routes::get('/add_subject_form',
						[
							'as' => 'admin.manage.subject.partials.add_subject_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@add_subject_form'
						]);

					Routes::get('/subject_details_form',
						[
							'as' => 'admin.manage.subject.partials.subject_details_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_details_form'
						]);

					Routes::get('/delete_subject_form',
						[
							'as' => 'admin.manage.subject.partials.delete_subject_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@delete_subject_form'
						]);
					Routes::get('/subject_side_nav',
						[
							'as' => 'admin.manage.subject.partials.subject_side_nav'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_side_nav'
						]);

					/**
					* CRUD Subject Areas
					*/
					Routes::get('/subject_area_list_form',
						[
							'as' => 'admin.manage.subject.partials.subject_area_list_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_area_list_form'
						]);

					Routes::get('/subject_area_delete_form',
						[
							'as' => 'admin.manage.subject.partials.subject_area_delete_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_area_delete_form'
						]);

					Routes::get('/subject_area_details_form',
						[
							'as' => 'admin.manage.subject.partials.subject_area_details_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_area_details_form'
						]);

					Routes::get('/subject_area_add_form',
						[
							'as' => 'admin.manage.subject.partials.subject_area_add_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_area_add_form'
						]);
				});
			});

			Routes::group(['prefix' => 'grades'], function() {
				$grade_controller = 'FutureLesson\Admin\ManageGradeController';

				Routes::get('/',
					[
						'as' => 'admin.manage.grades.index'
						, 'middleware' => 'admin'
						, 'uses' => $grade_controller . '@index'
					]);

				Routes::group(['prefix' => 'partial'], function() {
					$grade_controller = 'FutureLesson\Admin\ManageGradeController';

					Routes::get('/grade_list_form',
						[
							'as' => 'admin.manage.grades.partials.grade_list_form'
							, 'middleware' => 'admin'
							, 'uses' => $grade_controller . '@grade_list_form'
						]);

					Routes::get('/add_grade_form',
						[
							'as' => 'admin.manage.grades.partials.add_grade_form'
							, 'middleware' => 'admin'
							, 'uses' => $grade_controller . '@add_grade_form'
						]);

					Routes::get('/grade_details_form',
						[
							'as' => 'admin.manage.grades.partials.grade_details_form'
							, 'middleware' => 'admin'
							, 'uses' => $grade_controller . '@grade_details_form'
						]);

					Routes::get('/delete_grade_form',
						[
							'as' => 'admin.manage.grades.partials.delete_grade_form'
							, 'middleware' => 'admin'
							, 'uses' => $grade_controller . '@delete_grade_form'
						]);
					Routes::get('/grade_side_nav',
						[
							'as' => 'admin.manage.grades.partials.grade_side_nav'
							, 'middleware' => 'admin'
							, 'uses' => $grade_controller . '@grade_side_nav'
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

			Routes::group(['prefix' => '/invoice'], function() {

				$manage_invoice_controller = 'FutureLesson\Admin\ManageInvoiceController';

				Routes::get('/', [
							'as' => 'admin.manage.invoice.index',
							'middleware' => 'admin',
							'uses' => $manage_invoice_controller . '@index'
						]);

				Routes::group(['prefix' => '/partials'], function() {

					$manage_invoice_controller = 'FutureLesson\Admin\ManageInvoiceController';

					Routes::get('/invoice_list', [
						'as' => 'admin.manage.invoice.partials.invoice_list',
						'middleware' => 'admin',
						'uses' => $manage_invoice_controller . '@invoice_list'
					]);

					Routes::get('/view_invoice', [
						'as' => 'admin.manage.invoice.partials.view_invoice',
						'middleware' => 'admin',
						'uses' => $manage_invoice_controller . '@view_invoice'
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
