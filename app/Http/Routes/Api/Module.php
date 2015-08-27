<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
], function(){

	Routes::resource('/module/admin', 'Api\v1\AdminModuleController',
		['except' => ['create', 'edit']]);

	Routes::resource('/module/student','Api\v1\StudentModuleController',
		['except' => ['create', 'store', 'edit', 'destroy']]);

	Routes::resource('/module','Api\v1\ModuleController',
		['only' => ['index', 'show']]);

});