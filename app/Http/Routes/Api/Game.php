<?php

Routes::group([
	'middleware' => ['api_user', 'api_after'],
	'permission' => ['admin', 'client', 'student'],
	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
],function(){

	Routes::resource('/game','Api\v1\GameController',[
		'only' => ['index','show']
	]);
});