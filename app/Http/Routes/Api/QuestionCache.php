<?php
Routes::group([
//	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::resource('/question-cache','Api\v1\QuestionCacheController',
		['except' => ['create','edit']]);

	Routes::get('/generate-question',[
		'uses' => 'Api\v1\QuestionCacheController@generationQuestions',
		'as' => 'api.v1.generate-question'
	]);

	Routes::get('/preview-question',[
		'uses' => 'Api\v1\QuestionCacheController@previewQuestion',
		'as' => 'api.v1.preview-question'
	]);
});