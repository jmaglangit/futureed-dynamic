<?php
Routes::group([
	'prefix' => '/localization',
//	'middleware' => ['api_user','api_after'],
//	'permission' => ['admin'],
//	'role' => ['admin','super admin']
], function(){

	Routes::get('/languages',[
		'as' => 'api.v1.localization.languages',
		'uses' => 'Api\v1\LanguageController@getLanguages'
	]);
	Routes::post('/initialize-language',[
		'as' => 'api.v1.localization.initialize-language',
		'uses' => 'Api\v1\LanguageController@initializeLanguage'
	]);
});