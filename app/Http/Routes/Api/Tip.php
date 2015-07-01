<?php

Routes::group(['prefix' => '/tip'], function() {



		Routes::resource('/student', 'Api\v1\StudentTipController',
			['except' => ['create', 'edit']]);



});