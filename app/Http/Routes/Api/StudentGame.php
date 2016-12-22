<?php


Routes::group([
//	'middleware' => ['api_user', 'api_after'],
//	'permission' => ['admin', 'client', 'student'],
//	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
],function(){

	Routes::resource('/student-game','Api\v1\StudentGameController',[
		'only' => ['index','show']
	]);

	Routes::get('/students-game/{user_id}',[
		'uses' => 'Api\v1\StudentGameController@getStudentsGame',
		'as' => 'students.game'
	]);

	Routes::post('/student-game/buy',[
		'uses' => 'Api\v1\StudentGameController@studentBuyGame',
		'as' => 'student.buy.game'
	]);

	Routes::post('/student-game/time',[
		'uses' => 'Api\v1\StudentGameController@studentPlayTime',
		'as' => 'api.v1.student.play.time'
	]);

	Routes::get('/student-game/time-played/{student_id}',[
		'uses' => 'Api\v1\StudentGameController@getStudentPlayTime',
		'as' => 'api.v1.student.play.time-played'
	]);
});