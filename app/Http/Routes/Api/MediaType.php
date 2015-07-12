<?php

Routes::group(['prefix' => '/media-type'], function() {



	Routes::resource('/admin', 'Api\v1\AdminMediaTypeController',
		['except' => ['create', 'edit']]);





});