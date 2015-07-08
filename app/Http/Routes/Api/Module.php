<?php

Routes::group(['prefix' => '/module'], function() {

	Routes::resource('/admin', 'Api\v1\AdminModuleController',
		['except' => ['create', 'edit']]);

	Routes::resource('/student','Api\v1\ModuleController',
		['except' => ['create', 'edit']]);

});


