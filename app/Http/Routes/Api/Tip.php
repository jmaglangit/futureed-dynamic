<?php

Routes::group(['prefix' => '/tip'], function() {



		Routes::resource('/student', 'Api\v1\StudentTipController',
			['except' => ['create', 'edit']]);


		Routes::resource('/admin', 'Api\v1\AdminTipController',
			['except' => ['create', 'edit']]);

		Routes::put('/update-status/{id}', [
				'uses' => 'Api\v1\TipController@updateTipStatus',
				'as' => 'tip.update.status']);

		Routes::resource('/teacher', 'Api\v1\TeacherTipController',
			['except' => ['create', 'edit']]);



});