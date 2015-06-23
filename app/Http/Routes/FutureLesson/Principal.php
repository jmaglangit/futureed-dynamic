<?php
	/**
	* Principal Routes
	*
	* @return /principal/
	*/
	Routes::group(array(
			'prefix' => 'principal'
			, 'middleware' => ['client', 'principal']), function() {

		$manage_principal_controller = 'FutureLesson\Client\ManagePrincipalController';
		
		Routes::get('/', [
			'as' => 'client.principal.index',
			'middleware' => 'client',
			'uses' => $manage_principal_controller . '@index'
		]);

		/**
		* Manage Teacher Routes (CRUD)
		*/
		Routes::group(['prefix' => 'teacher'], function() {

			$manage_principal_teacher_controller = 'FutureLesson\Client\ManagePrincipalTeacherController';
			
			Routes::get('/', [
				'as' => 'client.principal.teacher.index',
				'uses' => $manage_principal_teacher_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function(){
			$manage_principal_teacher_controller = 'FutureLesson\Client\ManagePrincipalTeacherController';

				Routes::get('list_teacher_form', [
						'as' => 'client.principal.teacher.partials.list_teacher_form',
						'uses' => $manage_principal_teacher_controller . '@list_teacher_form'
					]);
				Routes::get('add_teacher_form', [
						'as' => 'client.principal.teacher.partials.add_teacher_form',
						'uses' => $manage_principal_teacher_controller . '@add_teacher_form'
					]);

				Routes::get('view_teacher_form', [
						'as' => 'client.principal.teacher.partials.view_teacher_form',
						'uses' => $manage_principal_teacher_controller . '@view_teacher_form'
					]);
				Routes::get('delete_teacher_form', [
					'as' => 'client.principal.teacher.partials.delete_teacher_form',
						'uses' => $manage_principal_teacher_controller . '@delete_teacher_form'
					]);
			});

		});

		/**
		* Manage Payment Routes (Add, List)
		*/
		Routes::group(['prefix' => 'payment'], function(){
			$manage_payment_controller = 'FutureLesson\Client\ManagePrincipalPaymentController';

			Routes::get('/', [
					'as' => 'client.principal.payment.index',
					'uses' => $manage_payment_controller . '@index'
				]);

			Routes::get('payment_form', [
					'as' => 'client.principal.payment.partials.payment_form',
					'uses' => $manage_payment_controller . '@payment_form'
				]);

			Routes::get('add_payment_form', [
					'as' => 'client.principal.payment.partials.add_payment_form',
					'uses' => $manage_payment_controller . '@add_payment_form'
				]);

			Routes::get('view_payment_form', [
					'as' => 'client.principal.payment.partials.view_payment_form',
					'uses' => $manage_payment_controller . '@view_payment_form'
				]);
		});

		/**
		* Manage Invoice Routes (List, Update)
		*/
		Routes::group(['prefix' => 'invoice'], function(){
			$manage_invoice_controller = 'FutureLesson\Client\ManagePrincipalInvoiceController';

			Routes::get('/', [
					'as' => 'client.principal.invoice.index',
					'uses' => $manage_invoice_controller. '@index'
				]);

			Routes::get('invoice_form', [
					'as' => 'client.principal.invoice.partials.invoice_form',
					'uses' => $manage_invoice_controller . '@invoice_form'
				]);
		});
	});