<?php

Routes::get('/question-answer',[
	'uses' => 'Api\v1\QuestionAnswerController@index',
	'as' => 'api.v1.question-answer.index',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);