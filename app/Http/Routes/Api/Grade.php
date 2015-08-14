<?php

/**
 * Get predefined types of grades.
 */
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
], function()
{
	Routes::resource('/grade','Api\v1\GradeController',
		['except' => ['create','edit']]);

    Routes::put('grade/update/{id}',[
            'uses' => 'Api\v1\GradeCustomController@update',
            'as' =>'api.v1.grade.update' ]);
});



