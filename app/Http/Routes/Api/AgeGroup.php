<?php

Routes::get('/age-group',[
	'uses' => 'Api\v1\AgeGroupController@index',
	'as' => 'api.v1.age-group',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);
