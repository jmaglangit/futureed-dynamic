<?php


Routes::post('/module/icon',[
	'uses' => 'Api\v1\AdminModuleIconController@store',
	'as' => 'api.v1.icons'
]);