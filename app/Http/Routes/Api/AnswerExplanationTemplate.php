<?php
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::resource('/answer-explanation-template','Api\v1\AnswerExplanationTemplateController',
		['except' => ['create','edit']]);
});