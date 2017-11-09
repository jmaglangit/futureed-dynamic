<?php


Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
], function()
{
	Routes::resource('/help-request','Api\v1\HelpRequestController',
		['except' => ['create','edit']]);

    Routes::patch('/help-request/update-request-status/{id}', [
        'uses' => 'Api\v1\HelpRequestController@update',
        'as' => 'help-request.patch.update-request-status']);

    Routes::patch('/help-request/update-question-status/{id}', [
        'uses' => 'Api\v1\HelpRequestController@update',
        'as' => 'help-request.patch.update-question-status']);
});