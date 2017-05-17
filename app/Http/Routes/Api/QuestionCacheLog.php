<?php
Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::resource('/question-cache-log','Api\v1\QuestionCacheLogController',
		['except' => ['create','edit']]);
});