<?php

Routes::group([
//	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::get('/answer-explanation',[
		'uses' => 'Api\v1\AnswerExplanationController@getAnswerExplanation',
		'as' => 'api.v1.answer-explanation.specific'
	]);
});