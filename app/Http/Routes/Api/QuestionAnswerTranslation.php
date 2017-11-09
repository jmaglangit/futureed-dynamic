<?php
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::group([
		'prefix' => '/question-answer-translation',
	], function (){

		Routes::get('/generate-language/{locale}',[
			'as' => 'question-answer-translate.generate-language',
			'uses' => 'Api\v1\QuestionAnswerTranslationController@generateNewLanguage'
		]);

		Routes::get('/check-language/{locale}',[
			'as' => 'question-answer-translate.check-language',
			'uses' => 'Api\v1\QuestionAnswerTranslationController@checkLanguageAvailability'
		]);

		Routes::get('/languages',[
			'as' => 'question-answer-translate.languages',
			'uses' => 'Api\v1\QuestionAnswerTranslationController@getLanguageTranslation'
		]);

		Routes::get('/attributes',[
			'as' => 'question-answer-translate.attributes',
			'uses' => 'Api\v1\QuestionAnswerTranslationController@getTranslatedAttributes'
		]);

		Routes::post('/google-translate',[
			'as' => 'question-answer-translate.google-translate',
			'uses' => 'Api\v1\QuestionAnswerTranslationController@googleTranslate'
		]);
	});
});