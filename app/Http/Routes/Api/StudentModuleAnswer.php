<?php

Routes::post('/student-module-answer',[
	'uses' => 'Api\v1\StudentModuleAnswerController@store',
	'as' => 'api.v1.student-module-answer.store',
	'Middleware' => ['api_user','api_after'],
	'permission' => ['student']
]);