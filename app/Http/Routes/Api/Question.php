<?php

//TODO: Removed from Authorization.
Routes::post('question/upload-image/',[
	'as' => 'api.v1.admin.image.upload',
	'uses' => 'Api\v1\QuestionController@uploadQuestionImage'
]);

Routes::post('question/answer/upload-image/',[
	'as' => 'api.v1.admin.answer.image.upload',
	'uses' => 'Api\v1\QuestionAnswerController@uploadQuestionAnswerImage']);


Routes::group([
	'prefix' => '/question',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function() {

	Routes::resource('/admin', 'Api\v1\AdminQuestionController',
		['except' => ['create', 'edit']]);


	Routes::resource('/answer/admin', 'Api\v1\AdminQuestionAnswerController',
		['except' => ['create', 'edit']]);

	Routes::post('/graph-answer/admin/{question_id}',[
		'as' => 'api.v1.question.graph-answer.admin',
		'uses' => 'Api\v1\AdminQuestionGraphAnswerController@UpdateGraphAnswer'
	]);



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

	Routes::get('student/question/graph/{question_id}',[
		'uses' => 'Api\v1\StudentQuestionController@graph',
		'as' => 'api.v1.student.question.graph'
	]);
});




