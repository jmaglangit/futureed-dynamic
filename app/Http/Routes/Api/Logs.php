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

	/**
	 * Security
	 */
	Routes::get('/security',[
		'uses' => 'Api\Logs\SecurityLogController@index',
		'as' => 'api.log.security.list'
	]);

	/**
	 * Admin
	 */
	Routes::get('/admin',[
		'uses' => 'Api\Logs\AdminLogController@index',
		'as' => 'api.log.admin.list'
	]);

	/**
	 * Error Logs
	 */
	Routes::get('/error',[
		'uses' => 'Api\Logs\ErrorLogController@getErrorLogs',
		'as' => 'api.log.error.files'
	]);

	/**
	 * Download Log
	 */
	Routes::get('/error/{filename}',[
		'uses' => 'Api\Logs\ErrorLogController@downloadErrorLog',
		'as' => 'api.log.error.file.download'
	]);


});