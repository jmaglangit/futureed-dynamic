<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
], function(){

	Routes::delete('/order-detail/{id}',[
		'uses' => 'Api\v1\OrderDetailController@destroy',
		'as' => 'api.v1.order-detail.destroy'
	]);

	Routes::get('/order-detail/get-students/{order_id}', [
		'uses' => 'Api\v1\ParentStudentController@getStudents',
		'as' => 'order-detail.get.students']);
});