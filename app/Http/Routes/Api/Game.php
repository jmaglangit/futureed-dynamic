<?php

Routes::group([
	'middleware' => ['api_user', 'api_after'],
	'permission' => ['admin', 'client', 'student'],
	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
],function(){

	Routes::resource('/game','Api\v1\GameController',[
		'only' => ['index','show']
	]);

	Routes::get('/game-student/{user_id}',[
		'as' => 'game.with.student',
		'uses' => 'Api\v1\GameController@getGamesWithUser'
	]);
});