<?php

Routes::group([
	'prefix' => '/log',
//	'middleware' => ['api_user', 'api_after'],
//	'permission' => ['admin', 'client', 'student'],
//	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
], function () {

	/**
	 * User
	 */
	Routes::get('/user',[
		'uses' => 'Api\Logs\UserLogController@index',
		'as' => 'api.log.user.list'
	]);


});