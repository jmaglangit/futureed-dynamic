<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::get('/image',[
		'uses' => 'Api\v1\ImageController@getImage',
		'as' => 'api.v1.image.get'
	]);

	Routes::post('/image/delete',[
		'uses' => 'Api\v1\ImageController@deleteImage',
		'as' => 'api.v1.image.delete'
	]);

});
