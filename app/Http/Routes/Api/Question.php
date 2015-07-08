<?php

Routes::group(['prefix' => '/question'], function() {



	Routes::resource('/admin', 'Api\v1\AdminQuestionController',
		['except' => ['create', 'edit']]);

	Routes::post('/update-image/{id}',[
		'as' => 'api.v1.admin.image.update',
		'uses' => 'Api\v1\QuestionController@updateQuestionImage'
	]);

	Routes::resource('/answer/admin', 'Api\v1\AdminQuestionAnswerController',
		['except' => ['create', 'edit']]);

	Routes::post('/class/update-image/{id}',[
		'as' => 'api.v1.admin.answer.image.update',
		'uses' => 'Api\v1\QuestionAnswerController@updateQuestionAnswerImage']);


});