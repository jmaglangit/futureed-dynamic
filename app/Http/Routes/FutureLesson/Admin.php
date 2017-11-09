<?php 
	Routes::group(['prefix' => '/peaches'], function()
	{
		Routes::get('/image', [
			'as' => 'admin.image.viewer'
			, 'uses' => 'FutureLesson\Admin\ImageController@view'
		]);

		Routes::get('/', 'FutureLesson\Admin\LoginController@index');
		
		Routes::get('/password/forgot',[
				'as' => 'admin.password.reset'
				, 'uses' => 'FutureLesson\Admin\LoginController@forgotPass'
			]);
		Routes::get('/base_url',[
				'as' => 'admin.base_url'
				, 'uses' => 'FutureLesson\Admin\LoginController@base_url'
			]);
		Routes::post('/update-user-session',[
				'as' => 'admin.update_user_session'
				, 'uses' => 'FutureLesson\Admin\LoginController@update_session'
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
					$admin_partials = 'admin.manage.admin.partials.';

					Routes::get('/list_admin_form', [
						  'as' => $admin_partials . 'list_admin_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@list_admin_form'
					]);

					Routes::get('/add_admin', [
						  'as' => $admin_partials . 'add_admin'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@add_admin'
					]);
					Routes::get('/view_admin', [
						  'as' => $admin_partials . 'view_admin'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@view_admin'
					]);
					Routes::get('/reset_pass', [
						  'as' => $admin_partials . 'reset_pass'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@reset_pass'
					]);
					Routes::get('/edit_email_form', [
						  'as' => $admin_partials . 'edit_email_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_admin_controller . '@edit_email_form'
					]);
					Routes::get('/delete_admin_form', [
						  'as' => $admin_partials . 'delete_admin_form'
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
					$client_partials = 'admin.manage.client.partials.';

					Routes::get('/list_client_form', [
						  'as' => $client_partials . 'list_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@list_client_form'
					]);

					Routes::get('/add_client_form', [
						  'as' => $client_partials . 'add_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@add_client_form'
					]);

					Routes::get('/client_details_form', [
						  'as' => $client_partials . 'client_details_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@client_details_form'
					]);

					Routes::get('/edit_email_form', [
						  'as' => $client_partials . 'edit_email_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@edit_email_form'
					]);

					Routes::get('/confirm_email_form', [
						  'as' => $client_partials . 'confirm_email_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@confirm_email_form'
					]);

					Routes::get('/delete_client_form', [
						  'as' => $client_partials . 'delete_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@delete_client_form'
					]);

					Routes::get('/import_client_form', [
						'as' => $client_partials . 'import_client_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_client_controller . '@import'
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
					$student_partials = 'admin.manage.student.partials.';

					Routes::get('/list_student_form',
						[
							'as' => $student_partials . 'list_student_form'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@list_student_form'
						]);
					Routes::get('/add_student_form',
						[
							'as' => $student_partials . 'add_student_form'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@add_student_form'
						]);
					Routes::get('/view_student_form',
						[
							'as' => $student_partials . 'view_student_form'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@view_student_form'
						]);
					Routes::get('/delete_student_form',
						[
							'as' => $student_partials . 'delete_student_form'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@delete_student_form'
						]);

					Routes::get('/reward',
						[
							'as' => $student_partials . 'reward'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@reward'
						]);

					Routes::get('/edit_reward',
						[
							'as' => $student_partials . 'edit_reward'
							, 'middleware' => 'admin'
							, 'uses' => $manage_student_controller . '@edit_reward'
						]);

					Routes::get('/import',[
						'as'=> $student_partials . 'import_student_form'
						, 'middleware' => 'admin'
						, 'uses' => $manage_student_controller . '@import'
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
					$subject_partials = 'admin.manage.subject.partials.';

					Routes::get('/subject_list_form',
						[
							'as' => $subject_partials . 'subject_list_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_list_form'
						]);

					Routes::get('/add_subject_form',
						[
							'as' => $subject_partials . 'add_subject_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@add_subject_form'
						]);

					Routes::get('/subject_details_form',
						[
							'as' => $subject_partials . 'subject_details_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_details_form'
						]);

					Routes::get('/delete_subject_form',
						[
							'as' => $subject_partials . 'delete_subject_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@delete_subject_form'
						]);

					/**
					* CRUD Subject Areas
					*/
					Routes::get('/subject_area_list_form',
						[
							'as' => $subject_partials . 'subject_area_list_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_area_list_form'
						]);

					Routes::get('/subject_area_delete_form',
						[
							'as' => $subject_partials . 'subject_area_delete_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_area_delete_form'
						]);

					Routes::get('/subject_area_details_form',
						[
							'as' => $subject_partials . 'subject_area_details_form'
							, 'middleware' => 'admin'
							, 'uses' => $subject_controller . '@subject_area_details_form'
						]);

					Routes::get('/subject_area_add_form',
						[
							'as' => $subject_partials . 'subject_area_add_form'
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
							Routes::get('subscription',
								[
									'as' => 'admin.manage.price.partials.subscription'
									, 'middleware' => 'admin'
									, 'uses' => $price_controller . '@subscription'
								]);
							Routes::get('subscription_days',
								[
									'as' => 'admin.manage.price.partials.subscription_days'
									, 'middleware' => 'admin'
									, 'uses' => $price_controller . '@subscription_days'
								]);
							Routes::get('subscription_packages',[
								'as' => 'admin.manage.price.partials.subscription_packages'
								, 'middleware' => 'admin'
								, 'uses' => $price_controller . '@subscription_packages'
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

			Routes::group(['prefix' => '/tips'], function() {

				Routes::get('/', 
					['as' => 'admin.manage.tips.index'
						, 'uses' => 'FutureLesson\Admin\ManageTipsController@index'
					]);

				Routes::group(['prefix' => '/patials'], function() {

					Routes::get('/detail', 
						['as' => 'admin.manage.tips.partials.detail'
						, 'uses' => 'FutureLesson\Admin\ManageTipsController@detail_form'
					]);

					Routes::get('/list', 
						['as' => 'admin.manage.tips.partials.list'
						, 'uses' => 'FutureLesson\Admin\ManageTipsController@list_form'
					]);

					Routes::get('/delete', 
						['as' => 'admin.manage.tips.partials.delete'
						, 'uses' => 'FutureLesson\Admin\ManageTipsController@delete_form'
					]);
				});
			});

			Routes::group(['prefix' => '/help_request'], function() {

				Routes::get('/', 
					['as' => 'admin.manage.help.index'
						, 'uses' => 'FutureLesson\Admin\ManageHelpRequestController@index'
					]);

				Routes::group(['prefix' => '/patials'], function() {

					Routes::get('/detail', 
						['as' => 'admin.manage.help.partials.detail'
						, 'uses' => 'FutureLesson\Admin\ManageHelpRequestController@detail_form'
					]);

					Routes::get('/list', 
						['as' => 'admin.manage.help.partials.list'
						, 'uses' => 'FutureLesson\Admin\ManageHelpRequestController@list_form'
					]);

					Routes::get('/delete', 
						['as' => 'admin.manage.help.partials.delete'
						, 'uses' => 'FutureLesson\Admin\ManageHelpRequestController@delete_form'
					]);
				});
			});

			Routes::group(['prefix' => '/request_answers'], function() {

				Routes::get('/', 
					['as' => 'admin.manage.answer.index'
						, 'uses' => 'FutureLesson\Admin\ManageHelpAnswerController@index'
					]);

				Routes::group(['prefix' => '/patials'], function() {

					Routes::get('/detail', 
						['as' => 'admin.manage.answer.partials.detail'
						, 'uses' => 'FutureLesson\Admin\ManageHelpAnswerController@detail_form'
					]);

					Routes::get('/list', 
						['as' => 'admin.manage.answer.partials.list'
						, 'uses' => 'FutureLesson\Admin\ManageHelpAnswerController@list_form'
					]);

					Routes::get('/delete', 
						['as' => 'admin.manage.answer.partials.delete'
						, 'uses' => 'FutureLesson\Admin\ManageHelpAnswerController@delete_form'
					]);
				});
			});
		});

		Routes::group(['prefix' => '/module'], function() {

				Routes::get('/', 
					['as' => 'admin.manage.module.index'
						, 'uses' => 'FutureLesson\Admin\ManageModuleController@index'
						, 'middleware' => 'admin_partial'
					]);

				Routes::get('/module_question',
					['as' => 'admin.manage.module.question'
						, 'uses' => 'FutureLesson\Admin\ManageModuleController@module_question'
					]);

				Routes::group(['prefix' => '/partials'], function() {

					Routes::get('/list_module_form', 
						['as' => 'admin.manage.module.partials.list_module_form'
						, 'uses' => 'FutureLesson\Admin\ManageModuleController@list_module_form'
						, 'middleware' => 'admin_partial'
					]);

					Routes::get('/add_module_form', 
						['as' => 'admin.manage.module.partials.add_module_form'
						, 'uses' => 'FutureLesson\Admin\ManageModuleController@add_module_form'
					]);

					Routes::get('/view_module_form', 
						['as' => 'admin.manage.module.partials.view_module_form'
						, 'uses' => 'FutureLesson\Admin\ManageModuleController@view_module_form'
					]);

					Routes::get('/module_questions_preview',
						['as' => 'admin.manage.module.partials.module_questions_preview'
						, 'uses' => 'FutureLesson\Admin\ManageModuleController@module_questions_preview'
					]);

					Routes::get('/dynamic_setup',[
						'as' => 'admin.manage.module.partials.dynamic_setup',
						'uses' => 'FutureLesson\Admin\ManageModuleController@dynamic_setup'
					]);
				});

				Routes::group(['prefix' => '/content'], function() {

					Routes::group(['prefix' => '/partials'], function() {

						Routes::get('/add', 
							['as' => 'admin.manage.module.content.partials.add'
							, 'uses' => 'FutureLesson\Admin\ManageModuleContentController@add_form'
						]);

						Routes::get('/detail', 
							['as' => 'admin.manage.module.content.partials.detail'
							, 'uses' => 'FutureLesson\Admin\ManageModuleContentController@detail_form'
						]);

						Routes::get('/list', 
							['as' => 'admin.manage.module.content.partials.list'
							, 'uses' => 'FutureLesson\Admin\ManageModuleContentController@list_form'
						]);

						Routes::get('/delete', 
							['as' => 'admin.manage.module.content.partials.delete'
							, 'uses' => 'FutureLesson\Admin\ManageModuleContentController@delete_form'
						]);
					});
				});
			});

			Routes::group(['prefix' => '/question-template'], function() {

				Routes::get('/', 
					['as' => 'admin.manage.question_template.index'
						, 'uses' => 'FutureLesson\Admin\ManageQuestionTempController@index'
						, 'middleware' => 'admin_partial'
					]);

				Routes::group(['prefix' => '/partials'], function() {
					$template_controller = 'FutureLesson\Admin\ManageQuestionTempController';
					$template_partials = 'admin.manage.question_template.partials.';

					Routes::get('/list_question_template', 
						['as' => $template_partials . 'list_question_template'
						, 'uses' => $template_controller . '@list_question_template'
						, 'middleware' => 'admin_partial'
					]);

					Routes::get('/add_question_template', 
						['as' => $template_partials . 'add_question_template'
						, 'uses' => $template_controller . '@add_question_template'
					]);

					Routes::get('/view_question_template', 
						['as' => $template_partials . 'view_question_template'
						, 'uses' => $template_controller . '@view_question_template'
					]);

					Routes::get('/question_template_variable',
						['as' => $template_partials . 'question_template_variable'
							, 'uses' => $template_controller . '@question_template_variable'
						]);

					Routes::get('/question_template_preview',
						['as' => $template_partials . 'question_template_preview'
							, 'uses' => $template_controller . '@question_template_preview'
						]);
				});

			});

		Routes::group(['prefix' => '/age_group'], function() {

			Routes::group(['prefix' => '/patials'], function() {

				Routes::get('/list_view_form', 
					['as' => 'admin.manage.age_group.partials.list_view_form'
					, 'uses' => 'FutureLesson\Admin\ManageAgeGroupController@list_view_form'
					, 'middleware' => 'admin_partial'
				]);

				Routes::get('/add_view_form', 
					['as' => 'admin.manage.age_group.partials.add_view_form'
					, 'uses' => 'FutureLesson\Admin\ManageAgeGroupController@add_view_form'
				]);

				Routes::get('/edit_view_form', 
					['as' => 'admin.manage.age_group.partials.edit_view_form'
					, 'uses' => 'FutureLesson\Admin\ManageAgeGroupController@edit_view_form'
				]);
			});
		});

		Routes::group(['prefix' => '/q_a'], function() {

				Routes::group(['prefix' => '/patials'], function() {

					Routes::get('/question_list_form', 
						['as' => 'admin.manage.question_answer.partials.question_list_form'
						, 'uses' => 'FutureLesson\Admin\ManageQuestionAnsController@question_list_form'
						, 'middleware' => 'admin_partial'
					]);

					Routes::get('/question_add_form', 
						['as' => 'admin.manage.question_answer.partials.question_add_form'
						, 'uses' => 'FutureLesson\Admin\ManageQuestionAnsController@question_add_form'
						, 'middleware' => 'admin_partial'
					]);

					Routes::get('/question_view_form', 
						['as' => 'admin.manage.question_answer.partials.question_view_form'
						, 'uses' => 'FutureLesson\Admin\ManageQuestionAnsController@question_view_form'
						, 'middleware' => 'admin_partial'
					]);

					Routes::get('/answer_list_form', 
						['as' => 'admin.manage.question_answer.partials.answer_list_form'
						, 'uses' => 'FutureLesson\Admin\ManageQuestionAnsController@answer_list_form'
						, 'middleware' => 'admin_partial'
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

		Routes::group(['prefix' => '/logs'], function()
		{
			Routes::get('/', [
					'as' => 'admin.manage.logs.index'
					, 'middleware' => 'admin'
					, 'uses' => 'FutureLesson\Admin\AdminLogsController@index'
				]);
			Routes::get('/security-list', [
					'as' => 'admin.manage.logs.partials.security_list_form'
					, 'uses' => 'FutureLesson\Admin\AdminLogsController@security_list_form'
				]);
			Routes::get('/administrator-list', [
					'as' => 'admin.manage.logs.partials.admin_list_form'
					, 'uses' => 'FutureLesson\Admin\AdminLogsController@admin_list_form'
				]);
			Routes::get('/user-list', [
					'as' => 'admin.manage.logs.partials.user_list_form'
					, 'uses' => 'FutureLesson\Admin\AdminLogsController@user_list_form'
				]);
			Routes::get('/system-list', [
					'as' => 'admin.manage.logs.partials.system_list_form'
					, 'uses' => 'FutureLesson\Admin\AdminLogsController@system_list_form'
				]);
			Routes::get('/errors-list', [
					'as' => 'admin.manage.logs.partials.errors_list_form'
					, 'uses' => 'FutureLesson\Admin\AdminLogsController@errors_list_form'
				]);
		});

		Routes::group(['prefix' => 'partials'], function() {
			Routes::get('/base_url', [
					'as' => 'admin.partials.base_url'
					, 'uses' => 'FutureLesson\Admin\LoginController@base_url'
				]);
		});

		Routes::group(['prefix' => '/localization'],function(){
			Routes::get('/index',[
				'as' => 'admin.manage.localization.index',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@index'
			]);
			Routes::get('/translations',[
				'as' => 'admin.manage.localization.translations',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@translation'
			]);
			Routes::get('/translations/module',[
				'as' => 'admin.manage.localization.translations.module',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@module'
			]);
			Routes::get('/translations/question',[
				'as' => 'admin.manage.localization.translations.question',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@question'
			]);
			Routes::get('/translations/question-answer',[
				'as' => 'admin.manage.localization.translations.question-answer',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@question_answer'
			]);
			Routes::get('/translations/answer-explanation',[
				'as' => 'admin.manage.localization.translations.answer-explanation',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@answer_explanation'
			]);
			Routes::get('/translations/quote',[
				'as' => 'admin.manage.localization.translations.quote',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@quote'
			]);
			Routes::get('/settings',[
				'as' => 'admin.manage.localization.settings',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@settings'
			]);
			Routes::get('/settings/main',[
				'as' => 'admin.manage.localization.settings.main',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@settings_main'
			]);
			Routes::get('/settings/job',[
				'as' => 'admin.manage.localization.settings.job',
				'uses' => 'FutureLesson\Admin\ManageTranslationController@job'
			]);
		});
	});
?>
