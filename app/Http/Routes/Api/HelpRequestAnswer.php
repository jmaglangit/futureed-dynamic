<?php


Routes::group(['prefix' => '/help-request-answer'],function(){

	Routes::post('/status/{id}','Api\v1\HelpRequestAnswerStatusController@updateStatus');
});

Routes::resource('/help-request-answer','Api\v1\HelpRequestAnswerController'
	, ['except' => ['create','edit']]
	);

