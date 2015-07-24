<?php

Routes::get('/image','Api\v1\ImageController@getImage');

Routes::post('/image/delete',[
	'uses' => 'Api\v1\ImageController@deleteImage',
	'as' => 'api.v1.image.delete'
]);