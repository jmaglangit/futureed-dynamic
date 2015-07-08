<?php

Routes::group(['prefix' => '/question'], function() {



	Routes::resource('/admin', 'Api\v1\AdminQuestionController',
		['except' => ['create', 'edit']]);

	Routes::post('/update-image/{id}',[
		'as' => 'api.v1.admin.image.update',
		'uses' => 'Api\v1\QuestionController@updateQuestionImage'
	]);


});