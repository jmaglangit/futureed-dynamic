<?php
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::resource('/question-cache','Api\v1\QuestionCacheController',
		['except' => ['create','edit']]);
});