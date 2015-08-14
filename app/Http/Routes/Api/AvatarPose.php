<?php

Routes::get('/avatar-pose',[
	'uses' => 'Api\v1\AvatarPoseController@index',
	'as' => 'api.v1.avatar-pose.index',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);
