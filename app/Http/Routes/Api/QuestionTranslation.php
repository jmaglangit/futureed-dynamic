<?php
Routes::group([
//	'middleware' => ['api_user','api_after'],
//	'permission' => ['admin'],
//	'role' => ['admin','super admin']
], function(){

	Routes::group([
		'prefix' => '/question-translation',
	], function (){

		Routes::get('/generate-language/{locale}',[
			'as' => 'question-translate.generate-language',
			'uses' => 'Api\v1\QuestionTranslationController@generateNewLanguage'
		]);

		Routes::get('/check-language/{locale}',[
			'as' => 'question-translate.check-language',
			'uses' => 'Api\v1\QuestionTranslationController@checkLanguageAvailability'
		]);

		Routes::get('/languages',[
			'as' => 'question-translate.languages',
			'uses' => 'Api\v1\QuestionTranslationController@getLanguageTranslation'
		]);

		Routes::get('/attributes',[
			'as' => 'question-translate.attributes',
			'uses' => 'Api\v1\QuestionTranslationController@getTranslatedAttributes'
		]);

		Routes::post('/google-translate',[
			'as' => 'question-translate.google-translate',
			'uses' => 'Api\v1\QuestionTranslationController@googleTranslate'
		]);
	});
});