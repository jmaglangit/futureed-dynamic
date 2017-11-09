<?php

Routes::post('/help-request-answer-rating',[
	'uses' => 'Api\v1\HelpRequestAnswerRatingController@store',
	'as' => 'api.v1.help-request-answer-rating.store',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);