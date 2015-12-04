<?php

Routes::get('/avatar-accessory',[
	'uses' => 'Api\v1\AvatarAccessoryController@getAvatarAccessories',
	'as' => 'api.v1.avatar-accessory.getAvatarAccessories',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);
