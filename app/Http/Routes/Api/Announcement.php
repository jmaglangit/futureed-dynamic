<?php 
Routes::resource('/announcement','Api\v1\AnnouncementController', ['only' => ['index']]);

Routes::post('/announcement',[
	'uses' => 'Api\v1\AnnouncementController@store',
	'as' => 'api.v1.announcement.store',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
]);