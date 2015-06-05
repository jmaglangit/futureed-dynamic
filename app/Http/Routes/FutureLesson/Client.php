<?php
	Routes::group(['prefix' => '/client'], function()
	{
		Routes::get('/', 'FutureLesson\Client\LoginController@index');
		
		Routes::get('/password/forgot', [
			'as' => 'client.password.forgot'
			, 'uses' =>'FutureLesson\Client\LoginController@forgot_password'
			]);
		Routes::get('/register/confirm', [
				'as' => 'client.register.confirm'
				, 'uses' => 'FutureLesson\Client\LoginController@enter_confirmation'
			]);
		Routes::get('/email/confirm', [
			'as' => 'client.email.confirm'
			, 'uses' => 'FutureLesson\Client\ProfileController@enter_email_code'
			]);
		Routes::get('/user/confirm', [
			'as' => 'client.user.confirm'
			, 'uses' => 'FutureLesson\Client\LoginController@user_confirm'
			]);
	
		Routes::get('/registration', [
			'as' => 'client.registration'
			, 'uses' => 'FutureLesson\Client\LoginController@registration'
		]);

		Routes::post('/update-user-session', [ 
				'as' => 'client.update_user_session'
				, 'uses' => 'FutureLesson\Client\ProfileController@update_session'
			]);

		Routes::get('/logout', [ 
			'as' => 'client.logout'
			, 'middleware' => 'client'
			, 'uses' => 'FutureLesson\Client\LoginController@logout'
		]);
				/**
				*@return /principal/{payment},{invoice},{partials}
				*/
		Routes::group(['prefix' => 'principal'], function(){
			$manage_principal_controller = 'FutureLesson\Client\ManagePrincipalController';
					Routes::get('/', [
								'as' => 'client.principal.index',
								'middleware' => 'client',
								'uses' => $manage_principal_controller . '@index'
							]);

					Routes::group(['prefix' => 'teacher'], function(){
						$manage_principal_teacher_controller = 'FutureLesson\Client\ManagePrincipalTeacherController';
						Routes::get('/', [
								'as' => 'client.principal.teacher.index',
								'middleware' => 'client',
								'uses' => $manage_principal_teacher_controller . '@index'
							]);

						Routes::group(['prefix' => 'partials'], function(){
						$manage_principal_teacher_controller = 'FutureLesson\Client\ManagePrincipalTeacherController';

							Routes::get('list_teacher_form', [
									'as' => 'client.principal.teacher.partials.list_teacher_form',
									'middleware' => 'client',
									'uses' => $manage_principal_teacher_controller . '@list_teacher_form'
								]);
							Routes::get('add_teacher_form', [
									'as' => 'client.principal.teacher.partials.add_teacher_form',
									'middleware' => 'client',
									'uses' => $manage_principal_teacher_controller . '@add_teacher_form'
								]);

							Routes::get('view_teacher_form', [
									'as' => 'client.principal.teacher.partials.view_teacher_form',
									'middleware' => 'client',
									'uses' => $manage_principal_teacher_controller . '@view_teacher_form'
								]);
							Routes::get('delete_teacher_form', [
								'as' => 'client.principal.teacher.partials.delete_teacher_form',
									'middleware' => 'client',
									'uses' => $manage_principal_teacher_controller . '@delete_teacher_form'
								]);
						});

					});

					Routes::group(['prefix' => 'payment'], function(){
						$manage_payment_controller = 'FutureLesson\Client\ManagePrincipalPaymentController';

						Routes::get('/', [
								'as' => 'client.principal.payment.index',
								'middleware' => 'client',
								'uses' => $manage_payment_controller . '@index'
							]);

						Routes::get('payment_form', [
								'as' => 'client.principal.payment.partials.payment_form',
								'middleware' => 'client',
								'uses' => $manage_payment_controller . '@payment_form'
							]);

						Routes::get('add_payment_form', [
								'as' => 'client.principal.payment.partials.add_payment_form',
								'middleware' => 'client',
								'uses' => $manage_payment_controller . '@add_payment_form'
							]);
					});

					Routes::group(['prefix' => 'invoice'], function(){
						$manage_invoice_controller = 'FutureLesson\Client\ManagePrincipalInvoinceController';

						Routes::get('/', [
								'as' => 'client.principal.invoice.index',
								'middleware' => 'client',
								'uses' => $manage_invoice_controller. '@index'
							]);

						Routes::get('invoice_form', [
								'as' => 'client.principal.invoice.partials.invoice_form',
								'middleware' => 'client',
								'uses' => $manage_invoice_controller . '@invoice_form'
							]);
					});
			});
				/**
				*@return /parent/{payment},{invoice},{partials}
				*/
			Routes::group(['prefix' => 'parent'], function(){
				$manage_parent_controller = 'FutureLesson\Client\ManageParentController';

				Routes::get('/', [
							'as' => 'client.parent.index',
							'middleware' => 'client',
							'uses' => $manage_parent_controller . '@index'
						]);

				Routes::group(['prefix' => 'student'], function(){
					$manage_parent_student_controller = 'FutureLesson\Client\ManageParentStudentController';

					Routes::get('/', [
							'as' => 'client.parent.student.index',
							'middleware' => 'client',
							'uses' => $manage_parent_student_controller . '@index'
						]);

					Routes::group(['prefix' => 'partials'], function(){
					$manage_parent_student_controller = 'FutureLesson\Client\ManageParentStudentController';

						Routes::get('list_student_form', [
								'as' => 'client.parent.student.parent.list_student_form',
								'middleware' => 'client',
								'uses' => $manage_parent_student_controller . '@list_student_form'
							]);
					});
				});				

				Routes::group(['prefix' => 'payment'], function(){

				$manage_parent_payment_controller = 'FutureLesson\Client\ManageParentPaymentController';

					Routes::get('/', [
								'as' => 'client.parent.payment.index',
								'middleware' => 'client',
								'uses' => $manage_parent_payment_controller . '@index'
							]);

					Routes::group(['prefix' => 'partials'], function(){

					$manage_parent_payment_controller = 'FutureLesson\Client\ManageParentPaymentController';

						Routes::get('payment_form', [
									'as' => 'client.parent.payment.partials.payment_form',
									'middleware' => 'client',
									'uses' => $manage_parent_payment_controller . '@payment_form'
								]);

						Routes::get('add_payment_form', [
									'as' => 'client.parent.payment.partials.add_payment_form',
									'middleware' => 'client',
									'uses' => $manage_parent_payment_controller . '@add_payment_form'
								]);
					});
				});

				Routes::group(['prefix' => 'invoice'], function(){

				$manage_parent_invoice_controller = 'FutureLesson\Client\ManageParentInvoiceController';

					Routes::get('/', [
								'as' => 'client.parent.invoice.index',
								'middleware' => 'client',
								'uses' => $manage_parent_invoice_controller . '@index'
							]);

					Routes::group(['prefix' => 'partials'], function(){

					$manage_parent_invoice_controller = 'FutureLesson\Client\ManageParentInvoiceController';

						Routes::get('invoice_form', [
									'as' => 'client.parent.invoice.partials.invoice_form',
									'middleware' => 'client',
									'uses' => $manage_parent_invoice_controller . '@invoice_form'
								]);
						});
					});
				});
				/**
				*@return /teacher/{payment},{invoice},{partials}
				*/
			Routes::group(['prefix' => 'teacher'], function(){
					$manage_teacher_controller = 'FutureLesson\Client\ManageTeacherController';

					Routes::get('/', [
							'as' => 'client.teacher.index',
							'middleware' => 'client',
							'uses' => $manage_teacher_controller . '@index'
						]);

					Routes::group(['prefix' => 'class'], function(){
					$manage_class_controller = 'FutureLesson\Client\ManageClassController';

						Routes::get('/', [
								'as' => 'client.teacher.class.index',
								'middleware' => 'client',
								'uses' => $manage_class_controller . '@index'
						]);

						Routes::group(['prefix' => 'partials'], function(){
						$manage_class_controller = 'FutureLesson\Client\ManageClassController';

							Routes::get('list_class_form', [
									'as' => 'client.teacher.class.partials.list_class_form',
									'middleware' => 'client',
									'uses' => $manage_class_controller . '@list_class_form'
							]);

							Routes::get('view_class_form', [
									'as' => 'client.teacher.class.partials.view_class_form',
									'middleware' => 'client',
									'uses' => $manage_class_controller . '@view_class_form'
							]);
							
							Routes::get('edit_class_form', [
									'as' => 'client.teacher.class.partials.edit_class_form',
									'middleware' => 'client',
									'uses' => $manage_class_controller . '@edit_class_form'
							]);

							Routes::get('add_student_form', [
									'as' => 'client.teacher.class.partials.add_student_form',
									'middleware' => 'client',
									'uses' => $manage_class_controller . '@add_student_form'
							]);
						});
					});

					Routes::group(['prefix' => 'student'], function(){
					$manage_teacher_student_controller = 'FutureLesson\Client\ManageTeacherStudentController';

						Routes::get('/', [
								'as' => 'client.teacher.student.index',
								'middleware' => 'client',
								'uses' => $manage_teacher_student_controller . '@index'
						]);

						Routes::group(['prefix' => 'partials'], function(){
						$manage_teacher_student_controller = 'FutureLesson\Client\ManageTeacherStudentController';

							Routes::get('list_student_form', [
									'as' => 'client.teacher.student.partials.list_student_form',
									'middleware' => 'client',
									'uses' => $manage_teacher_student_controller . '@list_student_form'
							]);

							Routes::get('view_student_form', [
									'as' => 'client.teacher.student.partials.view_student_form',
									'middleware' => 'client',
									'uses' => $manage_teacher_student_controller . '@view_student_form'
							]);
							Routes::get('email_student_form', [
									'as' => 'client.teacher.student.partials.email_student_form',
									'middleware' => 'client',
									'uses' => $manage_teacher_student_controller . '@email_student_form'
							]);
						});
					});
				});
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