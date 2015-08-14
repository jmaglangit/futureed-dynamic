<?php


Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::post('/help-request-answer/status/{id}',[
		'uses' => 'Api\v1\HelpRequestAnswerStatusController@updateStatus',
		'as' => 'api.v1.help-request-answer.status'
	]);

	Routes::resource('/help-request-answer','Api\v1\HelpRequestAnswerController',
		['except' => ['create','edit']]);
});