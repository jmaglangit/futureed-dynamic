<?php

Routes::group(['prefix' => '/question'], function() {



	Routes::resource('/admin', 'Api\v1\AdminQuestionController',
		['except' => ['create', 'edit']]);


});