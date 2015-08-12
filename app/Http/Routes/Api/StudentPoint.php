<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['student','admin'],
	'role' => ['admin','super admin']
],function(){

	Routes::resource('/student-point', 'Api\v1\StudentPointController',
		['except' => ['create', 'edit']]);


	Routes::resource('admin/student/point', 'Api\v1\AdminStudentPointController',
		['except' => ['create', 'edit']]);
});


