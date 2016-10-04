<?php

Routes::group([
	'prefix' => '/module-country',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::get('/',[
		'uses' => 'Api\v1\ModuleCountryController@index',
		'as' => 'api.v1.module-country.index'
	]);
});