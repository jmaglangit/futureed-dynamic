<?php

Routes::group(['prefix' => '/tip-rating'], function() {

	Routes::resource('/student', 'Api\v1\StudentTipRatingController',
		['except' => ['create', 'edit']]);


});