<?php

Routes::group(['prefix' => '/tip'], function() {



		Routes::resource('/student', 'Api\v1\StudentTipController',
			['except' => ['create', 'edit']]);


		Routes::resource('/admin', 'Api\v1\AdminTipController',
			['except' => ['create', 'edit']]);



});