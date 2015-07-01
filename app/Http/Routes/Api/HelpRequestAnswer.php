<?php


Routes::resource('/help-request-answer','Api\v1\HelpRequestAnswerController'
	, ['except' => ['create','edit']]
	);