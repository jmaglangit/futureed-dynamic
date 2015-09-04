<?php

Routes::group([
	'prefix' => '/question',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function() {

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


});

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::get('/question',[
		'uses' =>  'Api\v1\QuestionController@index',
		'as' => 'api.v1.question.index'
	]);

	Routes::get('student/question',[
		'uses' => 'Api\v1\StudentQuestionController@index',
		'as' => 'api.v1.student.question.index'
	]);
});




