<?php

Routes::group(['prefix' => '/learning-style'], function() {

	Routes::resource('/admin', 'Api\v1\AdminLearningStyleController',
		['except' => ['create', 'edit']]);
});