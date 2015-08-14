<?php

/**
 * Get Media type information.
 */
Routes::get('/media-type/admin',[
	'uses' => 'Api\v1\AdminMediaTypeController@index',
	'as' => 'api.v1.media-type.admin.index',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);