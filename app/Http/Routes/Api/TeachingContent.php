<?php

Routes::resource('/teaching-content','Api\v1\TeachingContentController',
	['except' => ['create', 'edit']]);

Routes::resource('/teaching-module/student','Api\v1\StudentTeachingContentController',
	['only' => ['index']]);

Routes::post('/teaching-content/upload-image/',[
	'as' => 'api.v1.admin.content.image.upload',
	'uses' => 'Api\v1\ContentController@uploadContentImage'
]);

