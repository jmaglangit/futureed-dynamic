<?php
Routes::group(['prefix' => '/avatar-accessory'], function() {
	Routes::get('/get-accessories',[
		'uses' => 'Api\v1\AvatarAccessoryController@getAvatarAccessories',
		'as' => 'api.v1.avatar-accessory.getAvatarAccessories',
		'middleware' => ['api_user','api_after'],
		'permission' => ['admin','client','student'],
		'role' => ['principal','teacher','parent','admin','super admin']
	]);

	Routes::post('/buy-accessory',[
		'uses' => 'Api\v1\AvatarAccessoryController@buyAvatarAccessory',
		'as' => 'api.v1.avatar-accessory.buyAvatarAccessory',
		'middleware' => ['api_user','api_after'],
		'permission' => ['admin','client','student'],
		'role' => ['principal','teacher','parent','admin','super admin']
	]);
});