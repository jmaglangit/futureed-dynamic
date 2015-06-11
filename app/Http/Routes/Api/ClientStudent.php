<?php
		Routes::group(['prefix' => '/parent-student'], function()
		{
			Routes::post('/add-existing-student', [
				'uses' => 'Api\v1\ParentStudentController@addExistingStudent',
				'as' => 'parent-student.add.existing.student']);

		});