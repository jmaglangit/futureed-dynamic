<?php

Routes::group(['prefix' => '/badge'], function() {

	/**
	 * Student Access
	 */
	Routes::group([
		'middleware' => ['api_user','api_after'],
		'permission' => ['student','admin'],
		'role' => ['admin','super admin']
	],function(){

		Routes::resource('/student', 'Api\v1\StudentBadgeController',
			['only' => ['index', 'show', 'update']]);
	});

	/**
	 * Admin Access
	 */
	Routes::group([
		'middleware' => ['api_user','api_after'],
		'permission' => ['admin'],
		'role' => ['admin','super admin']

	],function(){

		Routes::resource('/admin', 'Api\v1\BadgeController',
			['only' => ['index']]);
	});



});
