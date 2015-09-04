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

	Routes::get('/student-current-class',
		[
			'uses' => 'Api\v1\ClassStudentController@studentCurrentClass',
			'as' => 'api.v1.class-student.student-current-class'
		]);

	Routes::put('/student-remove-class/{id}',
		[
			'uses' => 'Api\v1\ClassStudentController@removeStudentClass',
			'as' => 'api.v1.class-student.student-remove-class'
		]);

	Routes::get('/student-class-list',
		[
			'uses' => 'Api\v1\ClassStudentController@index',
			'as' => 'api.v1.class-student.student-class-list'
		]);

});