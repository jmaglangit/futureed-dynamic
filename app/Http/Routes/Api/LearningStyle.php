<?php

/**
 * Types of Learning style.
 */

Routes::get('/learning-style/admin',[
	'uses' => 'Api\v1\AdminLearningStyleController@index',
	'as' => ' api.v1.learning-style.admin.index',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);