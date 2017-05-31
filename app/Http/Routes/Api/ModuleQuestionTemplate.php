<?php
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::resource('/module-question-template','Api\v1\ModuleQuestionTemplateController',
		['except' => ['create','edit']]);

	Routes::post('/module/question-template',[
		'as' => 'api.v1.module.question-template',
		'uses' => 'Api\v1\ModuleQuestionTemplateController@addModuleTemplates'
	]);

	Routes::get('/module/question-template/{module_id}',[
		'as' => 'api.v1.module.question-template.id',
		'uses' => 'Api\v1\ModuleQuestionTemplateController@getModuleTemplates'
	]);
});