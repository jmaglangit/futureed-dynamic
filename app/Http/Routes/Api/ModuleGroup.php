<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
], function(){

	Routes::resource('/module-group','Api\v1\ModuleGroupController',
		['except' => ['create','edit']]);

});