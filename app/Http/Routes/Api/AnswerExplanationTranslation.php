<?php
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::group([
		'prefix' => '/answer-explanation-translation',
	], function (){

		Routes::get('/generate-language/{locale}',[
			'as' => 'answer-explanation-translate.generate-language',
			'uses' => 'Api\v1\AnswerExplanationTranslationController@generateNewLanguage'
		]);

		Routes::get('/check-language/{locale}',[
			'as' => 'answer-explanation-translate.check-language',
			'uses' => 'Api\v1\AnswerExplanationTranslationController@checkLanguageAvailability'
		]);

		Routes::get('/languages',[
			'as' => 'answer-explanation-translate.languages',
			'uses' => 'Api\v1\AnswerExplanationTranslationController@getLanguageTranslation'
		]);

		Routes::get('/attributes',[
			'as' => 'answer-explanation-translate.attributes',
			'uses' => 'Api\v1\AnswerExplanationTranslationController@getTranslatedAttributes'
		]);

		Routes::post('/google-translate',[
			'as' => 'answer-explanation-translate.google-translate',
			'uses' => 'Api\v1\AnswerExplanationTranslationController@googleTranslate'
		]);
	});
});