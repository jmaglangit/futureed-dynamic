<?php

/**
 * Get basic country information.
 */
Routes::group([
	'prefix' => '/countries',
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