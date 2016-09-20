<?php
Routes::group([
	'prefix' => '/job',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::get('/queue',[
		'as' => 'api.v1.job.queue',
		'uses' => 'Api\v1\JobController@getQueueList'
	]);
});