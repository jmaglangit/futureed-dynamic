<?php 
Routes::group(['prefix' => '/class-student'], function()
{
	Routes::post('/add-existing-student', [
		'uses' => 'Api\v1\ClassStudentController@addExistingStudent',
		'as' => 'class-student.add.existing.student']);

	Routes::post('/add-new-student', [
		'uses' => 'Api\v1\ClassStudentController@addNewStudent',
		'as' => 'class-student.add.new.student']);

	Routes::post('/student-current-class',
		[
			'uses' => 'Api\v1\ClassStudentController@studentCurrentClass',
			'as' => 'api.v1.class-student.student-current-class'
		]);

	//TODO:  to replace student current class.
	Routes::post('/student-class',
		[
			'uses' => 'Api\v1\ClassStudentController@studentClassModules',
			'as' => 'api.v1.class-student.student-class'
		]);

	Routes::put('/student-remove-class/{id}',
		[
			'uses' => 'Api\v1\ClassStudentController@removeStudentClass',
			'as' => 'api.v1.class-student.student-remove-class'
		]);
});