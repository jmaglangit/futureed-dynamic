<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::post('payment', array(
		'as' => 'payment',
		'uses' => 'Api\v1\PaymentController@postPayment',
	));

	Routes::post('student-payment', array(
		'as' => 'student.payment',
		'uses' => 'Api\v1\StudentPaymentController@studentPayment'
	));
	
	Routes::put('student-payment-edit/{id}', array(
		'as' => 'student.payment.edit',
		'uses' => 'Api\v1\StudentPaymentController@studentPaymentEdit'
	));
});

// this is after make the payment, PayPal redirect back to your site
Routes::get('payment/status', array(
	'as' => 'payment.status',
	'uses' => 'Api\v1\PaymentController@getPaymentStatus',
));