<?php
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::group([
		'prefix' => '/quote-translation',
	], function (){

		Routes::get('/generate-language/{locale}',[
			'as' => 'quote-translate.generate-language',
			'uses' => 'Api\v1\QuoteTranslationController@generateNewLanguage'
		]);

		Routes::get('/check-language/{locale}',[
			'as' => 'quote-translate.check-language',
			'uses' => 'Api\v1\QuoteTranslationController@checkLanguageAvailability'
		]);

		Routes::get('/languages',[
			'as' => 'quote-translate.languages',
			'uses' => 'Api\v1\QuoteTranslationController@getLanguageTranslation'
		]);

		Routes::get('/attributes',[
			'as' => 'quote-translate.attributes',
			'uses' => 'Api\v1\QuoteTranslationController@getTranslatedAttributes'
		]);

		Routes::post('/google-translate',[
			'as' => 'quote-translate.google-translate',
			'uses' => 'Api\v1\QuoteTranslationController@googleTranslate'
		]);
	});
});