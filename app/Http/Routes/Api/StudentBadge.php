<?php

Routes::group(['prefix' => '/badge'], function() {

	Routes::resource('/student', 'Api\v1\StudentBadgeController',
		['except' => ['create', 'edit']]);

	Routes::resource('/admin', 'Api\v1\BadgeController',
		['except' => ['create', 'edit']]);

});
