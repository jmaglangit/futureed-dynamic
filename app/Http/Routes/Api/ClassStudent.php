<?php 
Routes::group([
	'prefix' => '/class-student',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
], function()
{
	Routes::post('/add-existing-student', [
		'uses' => 'Api\v1\ClassStudentController@addExistingStudent',
		'as' => 'class-student.add.existing.student']);

	Routes::post('/add-new-student', [
		'uses' => 'Api\v1\ClassStudentController@addNewStudent',
		'as' => 'class-student.add.new.student']);

	Routes::post('/student-join-class', [
			'uses' => 'Api\v1\ClassStudentController@studentJoinClass',
			'as' => 'api.v1.class-student.student-join-class'
		]);
});