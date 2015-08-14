<?php

/**
 * Get basic country information.
 */
Routes::group([
	'prefix' => '/countries',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::get('/',[
		'uses' => 'Api\v1\CountryController@index',
		'as' => 'api.v1.countries.index'
	]);

	Routes::get('/{id}',[
		'uses' => 'Api\v1\CountryController@show',
		'as' => 'api.v1.countries.show'
	]);
});