<?php

/**
 * Point Level Routes.
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','client','student'],
    'role' => ['principal','teacher','parent','admin','super admin']
], function(){
	Routes::resource('/point-level', 'Api\v1\PointLevelController', 
		['only' => ['index', 'show']]);	
});
