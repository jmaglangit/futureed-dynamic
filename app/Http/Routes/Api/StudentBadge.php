<?php

Routes::group(['prefix' => '/badge'], function() {

	/**
	 * Student Access
	 */
	Routes::group([
		'middleware' => ['api_user','api_after'],
		'permission' => ['student']
	],function(){

		Routes::resource('/student', 'Api\v1\StudentBadgeController',
			['except' => ['create', 'edit']]);
	});

	/**
	 * Admin Access
	 */
	Routes::group([
		'middleware' => ['api_user','api_after'],
		'permission' => ['admin'],
		'role' => ['admin','super_admin']

	],function(){

		Routes::resource('/admin', 'Api\v1\BadgeController',
			['except' => ['create', 'edit']]);
	});



});
