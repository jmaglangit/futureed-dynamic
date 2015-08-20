<?php


Routes::post('/icons',[
	'uses' => 'Api\v1\AdminModuleIconController@store',
	'as' => 'api.v1.icons'
]);