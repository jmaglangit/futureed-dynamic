<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['student','admin'],
	'role' => ['admin','super admin']
],function(){

	Routes::resource('/student-point', 'Api\v1\StudentPointController',
		['except' => ['create', 'edit', 'destroy']]);

	Routes::get('/student-point-cash',[
	'uses' => 'Api\v1\StudentPointController@getCashPoints',
	'as' => 'api.v1.student-point-cash',
]);


	Routes::resource('admin/student/point', 'Api\v1\AdminStudentPointController',
		['only' => ['update']]);
});


