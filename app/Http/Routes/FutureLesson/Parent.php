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
			});
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
	});