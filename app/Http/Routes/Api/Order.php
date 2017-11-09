<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::get('/order/get-next-order-no/{client_id}', [
		'uses' => 'Api\v1\OrderController@getNextOrderNo',
		'as' => 'order.get.next-order-no']);

	Routes::post('/order',[
		'uses' => 'Api\v1\OrderController@store',
		'as' => 'api.v1.order.store'
	]);

	Routes::get('/order/{id}',[
		'uses' => 'Api\v1\OrderController@show',
		'as' => 'api.v1.order.show'
	]);

	Routes::put('/order/{id}',[
		'uses' => 'Api\v1\OrderController@update',
		'as' => 'api.v1.order.update'
	]);

});