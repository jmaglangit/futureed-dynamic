<?php

/**
 * Get list of events.
 */
Routes::get('/event',[
	'uses' => 'Api\v1\EventController@index',
	'as' => 'api.v1.event.index',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);