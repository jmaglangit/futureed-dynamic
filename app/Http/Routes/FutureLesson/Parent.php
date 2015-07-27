<?php
	/**
	*@return /parent/{payment},{invoice},{partials}
	*/
	Routes::group(array(
			'prefix' => 'parent'
			, 'middleware' => ['client', 'parent']), function() {
	
		$manage_parent_controller = 'FutureLesson\Client\ManageParentController';

		Routes::get('/', [
			'as' => 'client.parent.index',
			'uses' => $manage_parent_controller . '@index'
		]);

		Routes::group(['prefix' => 'student'], function(){
			$manage_parent_student_controller = 'FutureLesson\Client\ManageParentStudentController';

			Routes::get('/', [
				'as' => 'client.parent.student.index',
				'uses' => $manage_parent_student_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function(){
				$manage_parent_student_controller = 'FutureLesson\Client\ManageParentStudentController';

				Routes::get('list_student_form', [
					'as' => 'client.parent.student.partials.list_student_form',
					'uses' => $manage_parent_student_controller . '@list_student_form'
				]);
			
				Routes::get('add_student_form', [
					'as' => 'client.parent.student.partials.add_student_form',
					'uses' => $manage_parent_student_controller . '@add_student_form'
				]);
		
				Routes::get('view_student_form', [
					'as' => 'client.parent.student.partials.view_student_form',
					'uses' => $manage_parent_student_controller . '@view_student_form'
				]);

				Routes::get('invitation_code_form', [
					'as' => 'client.parent.student.partials.invitation_code_form',
					'uses' => $manage_parent_student_controller . '@invitation_code_form'
				]);

				Routes::get('change_email_form', [
					'as' => 'client.parent.student.partials.change_email_form',
					'uses' => $manage_parent_student_controller . '@change_email_form'
				]);
			});
		});				

		Routes::group(['prefix' => 'payment'], function() {
			$manage_parent_payment_controller = 'FutureLesson\Client\ManageParentPaymentController';

			Routes::get('/', [
				'as' => 'client.parent.payment.index',
				'uses' => $manage_parent_payment_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function() {
				$manage_parent_payment_controller = 'FutureLesson\Client\ManageParentPaymentController';

				Routes::get('payment_form', [
					'as' => 'client.parent.payment.partials.payment_form',
					'uses' => $manage_parent_payment_controller . '@payment_form'
				]);

				Routes::get('add_payment_form', [
					'as' => 'client.parent.payment.partials.add_payment_form',
					'uses' => $manage_parent_payment_controller . '@add_payment_form'
				]);

				Routes::get('view_payment_form', [
					'as' => 'client.parent.payment.partials.view_payment_form',
					'uses' => $manage_parent_payment_controller . '@view_payment_form'
				]);
			});

			Routes::get('/success', [
					'as' => 'client.parent.payment.success',
					'uses' => $manage_parent_payment_controller . '@payment_success'
				]);

			Routes::get('/fail', [
					'as' => 'client.parent.payment.fail',
					'uses' => $manage_parent_payment_controller . '@payment_fail'
				]);
		});

		Routes::group(['prefix' => 'invoice'], function() {
			$manage_parent_invoice_controller = 'FutureLesson\Client\ManageParentInvoiceController';

			Routes::get('/', [
				'as' => 'client.parent.invoice.index',
				'uses' => $manage_parent_invoice_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function(){
				$manage_parent_invoice_controller = 'FutureLesson\Client\ManageParentInvoiceController';

				Routes::get('invoice_form', [
					'as' => 'client.parent.invoice.partials.invoice_form',
					'uses' => $manage_parent_invoice_controller . '@invoice_form'
				]);
			});
		});
		Routes::group(['prefix' => 'module'], function() {
			$manage_parent_module_controller = 'FutureLesson\Client\ManageParentModuleController';

			Routes::get('/', [
				'as' => 'client.parent.module.index',
				'uses' => $manage_parent_module_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function() {
				$manage_parent_module_controller = 'FutureLesson\Client\ManageParentModuleController';

				Routes::get('list_module_form', [
					'as' => 'client.parent.module.partials.list_module_form',
					'uses' => $manage_parent_module_controller . '@list_module_form'
				]);

				Routes::get('view_module', [
					'as' => 'client.parent.module.partials.view_module',
					'uses' => $manage_parent_module_controller . '@view_module'
				]);
			});

			Routes::group(['prefix' => 'teaching-content'], function() {
			$manage_parent_content_controller = 'FutureLesson\Client\ManageParentContentController';

			Routes::get('/', [
				'as' => 'client.parent.teaching_content.index',
				'uses' => $manage_parent_content_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function() {
				$manage_parent_content_controller = 'FutureLesson\Client\ManageParentContentController';

				Routes::get('list_content_form', [
					'as' => 'client.parent.teaching_content.partials.list_content_form',
					'uses' => $manage_parent_content_controller . '@list_content_form'
				]);
			});
		});
	});
	});