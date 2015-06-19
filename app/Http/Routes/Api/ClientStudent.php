<?php
		Routes::group(['prefix' => '/parent-student'], function()
		{
			Routes::post('/add-existing-student', [
				'uses' => 'Api\v1\ParentStudentController@addExistingStudent',
				'as' => 'parent-student.add.existing.student']);

			Routes::post('/confirm-student', [
				'uses' => 'Api\v1\ParentStudentController@parentConfirmStudent',
				'as' => 'parent-student.confirm.student']);

			Routes::put('/update-student/{id}', [
				'uses' => 'Api\v1\ParentStudentController@parentUpdateStudent',
				'as' => 'parent-student.update.student']);

		});

		Routes::group(['prefix' => '/client/manage'], function()
		{
			Routes::resource('/student','Api\v1\ClientStudentController',
				['except' => ['create','edit']]);

			//NOTE:student confirm his/her invitation via teacher
			Routes::put('/update-student/{id}', [
				'uses' => 'Api\v1\TeacherStudentController@studentRegistrationAfterInvitation',
				'as' => 'client-manage.update.student']);

			Routes::post('/view-student/{id}', [
				'uses' => 'Api\v1\TeacherStudentController@viewStudentDetailsByToken',
				'as' => 'client-manage.update.student']);

			Routes::put('/email/student/{id}', [
				'uses' => 'Api\v1\StudentEmailController@updateStudentEmail',
				'as' => 'parent-student.email.student']);


		});

