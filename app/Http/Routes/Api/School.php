<?php

Routes::group([
	'middleware' => ['api_user', 'api_after'],
	'permission' => ['admin', 'client', 'student'],
	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
], function () {


	/**
	 * School search
	 */
	Routes::Post('/school/search', [
		'uses' => 'Api\v1\SchoolSearchController@schoolSearch',
		'as' => 'api.v1.school.search.post'
	]);

	//search school
	Routes::get('/school/search',[
		'uses' =>  'Api\v1\SchoolSearchController@schoolSearch',
		'as' => 'api.v1.school.search.get'
	]);

	//schools
	Routes::resource('/school', 'Api\v1\SchoolController',
		['only' => ['index', 'show']]);

});


