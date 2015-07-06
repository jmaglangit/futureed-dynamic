<?php

Routes::group(['prefix' => '/module'], function() {

	Routes::resource('/admin', 'Api\v1\AdminModuleController',
		['except' => ['create', 'edit']]);

});