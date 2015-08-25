<?php


Routes::post('/module/icon',[
	'uses' => 'Api\v1\AdminModuleImageController@store',
	'as' => 'api.v1.icons'
]);