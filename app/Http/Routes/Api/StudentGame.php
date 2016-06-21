<?php


Routes::group([
	'middleware' => ['api_user', 'api_after'],
	'permission' => ['admin', 'client', 'student'],
	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
],function(){

	Routes::resource('/student-game','Api\v1\StudentGameController',[
		'only' => ['index','show']
	]);

	Routes::get('/students-game/{user_id}',[
		'uses' => 'Api\v1\StudentGameController@getStudentsGame',
		'as' => 'students.game'
	]);
});