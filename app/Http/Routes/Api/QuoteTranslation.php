<?php

Routes::post('/quote/generate-translation',[
	'uses' => 'Api\v1\QuoteTranslationController@generateTranslation',
	'as' => 'api.v1.quote.generate-translation',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);