<?php
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::resource('/module-question-template','Api\v1\ModuleQuestionTemplateController',
		['except' => ['create','edit']]);
});