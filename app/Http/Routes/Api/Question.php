<?php

Routes::group(['prefix' => '/question'], function() {



	Routes::resource('/admin', 'Api\v1\AdminQuestionController',
		['except' => ['create', 'edit']]);

	Routes::post('/upload-image/',[
		'as' => 'api.v1.admin.image.upload',
		'uses' => 'Api\v1\QuestionController@uploadQuestionImage'
	]);

	Routes::resource('/answer/admin', 'Api\v1\AdminQuestionAnswerController',
		['except' => ['create', 'edit']]);

	Routes::post('/answer/upload-image/',[
		'as' => 'api.v1.admin.answer.image.upload',
		'uses' => 'Api\v1\QuestionAnswerController@uploadQuestionAnswerImage']);

	Routes::post('/delete-image',[
		'as' => 'api.v1.delete-image',
		'uses' => 'Api\v1\QuestionAnswerController@deleteQuestionAnswerImage'
	]);

});

Routes::resource('/question', 'Api\v1\QuestionController',
	['except' => ['create', 'edit']]);
