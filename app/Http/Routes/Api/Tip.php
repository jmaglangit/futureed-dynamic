<?php

Routes::group(['prefix' => '/tip'], function() {

	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['student']
	], function () {

		Routes::resource('/student', 'Api\v1\StudentTipController',
			['except' => ['create', 'edit']]);
	});

	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['admin'],
		'role'	=> ['admin','super admin']
	], function () {

		Routes::resource('/admin', 'Api\v1\AdminTipController',
			['except' => ['create', 'edit']]);
	});


	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['client','admin'],
		'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
	], function () {

		Routes::put('/update-status/{id}', [
			'uses' => 'Api\v1\TipController@updateTipStatus',
			'as' => 'tip.update.status']);
	});

	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['admin', 'client', 'student'],
		'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
	], function () {

		Routes::resource('/teacher', 'Api\v1\TeacherTipController',
			['except' => ['create', 'edit']]);
	});

		Routes::get('/student-view-recent/', [
			'uses' => 'Api\v1\TipController@viewCurrentTips',
			'as' => 'tip.update.status']);

	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['admin', 'client', 'student'],
		'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
	], function () {

		Routes::resource('/question-content', 'Api\v1\StudentQuestionContentTipController',
			['except' => ['create', 'edit']]);
	});



});