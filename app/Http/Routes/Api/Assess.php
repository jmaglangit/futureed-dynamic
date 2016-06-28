<?php 
Routes::group(['prefix' => '/assess'], function() {

	Routes::get('/get-test',[
		'uses' => 'Api\v1\AssessController@getTest',
		'as' => 'api.v1.assess.get-test',
		'middleware' => ['api_user','api_after'],
		'permission' => ['student','admin'],
		'role' => ['admin','super admin']
	]);
		
	Routes::post('/save-test',[
		'uses' => 'Api\v1\AssessController@saveTest',
		'as' => 'api.v1.assess.save-test',
		'middleware' => ['api_user','api_after'],
		'permission' => ['student','admin'],
		'role' => ['admin','super admin']
	]);

	Routes::get('/download-report/{student_id}',[
		'uses' => 'Api\v1\AssessController@getReport',
		'as' => 'api.v1.assess.get-report',
		'middleware' => ['api_user','api_after'],
		'permission' => ['student','admin'],
		'role' => ['admin','super admin']
	]);
		
});