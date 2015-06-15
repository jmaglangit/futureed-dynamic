<?php
		Routes::group(['prefix' => '/parent-student'], function()
		{
			Routes::post('/add-existing-student', [
				'uses' => 'Api\v1\ParentStudentController@addExistingStudent',
				'as' => 'parent-student.add.existing.student']);

			Routes::post('/confirm-student', [
				'uses' => 'Api\v1\ParentStudentController@parentConfirmStudent',
				'as' => 'parent-student.confirm.student']);

		});