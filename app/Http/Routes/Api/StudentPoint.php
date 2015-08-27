<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['student','admin'],
	'role' => ['admin','super admin']
],function(){

	Routes::resource('/student-point', 'Api\v1\StudentPointController',
		['except' => ['create', 'edit', 'destroy']]);


	Routes::resource('admin/student/point', 'Api\v1\AdminStudentPointController',
		['only' => ['update']]);
});


