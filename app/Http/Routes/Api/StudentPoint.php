<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['student','admin'],
	'role' => ['admin','super admin']
],function(){

	Routes::resource('/student-point', 'Api\v1\StudentPointController',
		['except' => ['create', 'edit', 'destroy']]);

	Routes::get('/student-points-used',[
	'uses' => 'Api\v1\StudentPointController@getPointsUsed',
	'as' => 'api.v1.student-points-used',
]);


	Routes::resource('admin/student/point', 'Api\v1\AdminStudentPointController',
		['only' => ['update']]);
});


