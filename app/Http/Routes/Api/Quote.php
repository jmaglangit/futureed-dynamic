<?php

Routes::get('/quote',[
	'uses' => 'Api\v1\QuoteController@index',
	'as' => 'api.v1.quote.index',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);