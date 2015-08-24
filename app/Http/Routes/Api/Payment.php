<?php
Routes::post('payment', array(
    'as' => 'payment',
    'uses' => 'Api\v1\PaymentController@postPayment',
));

// this is after make the payment, PayPal redirect back to your site
Routes::get('payment/status', array(
    'as' => 'payment.status',
    'uses' => 'Api\v1\PaymentController@getPaymentStatus',
));

Routes::post('student-payment', array(
	'as' => 'student.payment',
	'uses' => 'Api\v1\StudentPaymentController@studentPayment'
));

Routes::put('student-payment-edit/{id}', array(
	'as' => 'student.payment.edit',
	'uses' => 'Api\v1\StudentPaymentController@studentPaymentEdit'
));