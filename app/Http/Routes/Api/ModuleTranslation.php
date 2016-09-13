<?php
Routes::group([
//	'middleware' => ['api_user','api_after'],
//	'permission' => ['admin'],
//	'role' => ['admin','super admin']
], function(){

	Routes::group([
		'prefix' => '/module-translation',
	], function (){

		Routes::post('/upload',[
			'as' => 'module-translation.upload',
			'uses' => 'Api\v1\ModuleTranslationController@addModuleTranslation'
		]);

		Routes::get('/generate-language/{locale}',[
			'as' => 'module-translate.generate-language',
			'uses' => 'Api\v1\ModuleTranslationController@generateNewLanguage'
		]);

		Routes::get('/check-language/{locale}',[
			'as' => 'module-translation.check-language',
			'uses' => 'Api\v1\ModuleTranslationController@checkLanguageAvailability'
		]);

		Routes::get('/generate/{local}',[
			'as' => 'module-translation.generate',
			'uses' => 'Api\v1\ModuleTranslationController@generateTranslationFile'
		]);

		Routes::get('/languages',[
			'as' => 'module-translation.languages',
			'uses' => 'Api\v1\ModuleTranslationController@getLanguageTranslation'
		]);

		Routes::get('/attributes',[
			'as' => 'module-translation.attributes',
			'uses' => 'Api\v1\ModuleTranslationController@getTranslatedAttributes'
		]);

		Routes::post('/google-translate',[
			'as' => 'module-translation.google-translate',
			'uses' => 'Api\v1\ModuleTranslationController@googleTranslate'
		]);

	});


});