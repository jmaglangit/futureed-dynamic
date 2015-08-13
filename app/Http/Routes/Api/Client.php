<?php

Routes::group(['prefix' => '/client'], function()
{
    /**
     * Authenticated client routes
     */
	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['admin', 'client'],
		'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin'],
	], function () {

		/**
		 * Parent resource
		 */
		Routes::resource('/parent', 'Api\v1\ClientParentController',
			['except' => ['create', 'edit']]);

		Routes::get('/parent/student/list/{id}', [
			'uses' => 'Api\v1\ClientParentController@getStudentList',
			'as' => 'api.v1.client.parent.student.list'
		]);

		/**
		 * Principal resource
		 */
		Routes::resource('/principal', 'Api\v1\ClientPrincipalController',
			['except' => ['create', 'edit']]);

		/**
		 * Teacher resource
		 */
		Routes::resource('/teacher', 'Api\v1\ClientTeacherController',
			['except' => ['create', 'edit']]);

		Routes::post('/change-password/{id}', [
			'uses' => 'Api\v1\ClientPasswordController@changePassword',
			'as' => 'api.v1.client.change-password'
		]);

		Routes::post('/new-password/{id}', [
			'uses' => 'Api\v1\ClientPasswordController@setPassword',
			'as' => 'api.v1.client.new-password'
		]);

		Routes::post('/change-email/{id}', [
			'uses' => 'Api\v1\EmailController@updateClientEmail',
			'as' => 'api.v1.client.change-email'
		]);
	});

	Routes::group([
		'middleware' => ['api_after_client_login'],
		'permission' => ['client'],
		'role' => ['principal', 'teacher', 'parent'],
	], function () {

        //teacher-information is for registration purposes, no auth token needed.
		Routes::get('/teacher-information/{id}', [
			'as' => 'api.v1.client.teacher.information',
			'uses' => 'Api\v1\ClientTeacherRegistrationController@getTeacherInformation'
		]);

		Routes::put('/teacher-information/{id}', [
			'as' => 'api.v1.client.teacher.information.update',
			'uses' => 'Api\v1\ClientTeacherRegistrationController@updateTeacherInformation'
		]);
	});

//NOTE: Token insert if login success.
	/**
	 * Client login
	 */
	Routes::post('/login', [
		'uses' => 'Api\v1\ClientLoginController@login',
		'as' => 'api.v1.client.login',
		'middleware' => ['api_after_client_login']
	]);

	Routes::post('/register', [
		'uses' => 'Api\v1\ClientRegisterController@register',
		'as' => 'api.v1.client.register',
		'middleware' => ['api_after_client_login']
	]);

	Routes::post('/reset-password/{id}', [
		'uses' => 'Api\v1\ClientPasswordController@resetPassword',
		'as' => 'api.v1.client.reset-password',
		'middleware' => ['api_after_client_login']
	]);

	/**
	 * Change client email
	 */
	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['admin', 'client', 'student'],
		'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin'],
	], function () {


		Routes::post('/resend-email/{id}', [
			'uses' => 'Api\v1\EmailController@resendChangeEmail',
			'as' => 'api.v1.client.resend-email'
		]);

		Routes::post('/update-email/{id}', [
			'uses' => 'Api\v1\EmailController@confirmChangeEmail',
			'as' => 'api.v1.client.update-email'
		]);
	});

	/**
	 * Authenticated routes of the client for admin access only.
	 */
	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['admin'],
		'role' => ['admin', 'super admin']
	], function () {

		/**
		 * Client verification through admin
		 */
		Routes::post('/verify-client/{id}', [
			'uses' => 'Api\v1\EmailController@verifyClient',
			'as' => 'api.v1.client.verify-client'
		]);

		/**
		 * Reject a client
		 */
		Routes::post('/reject-client/{id}', [
			'uses' => 'Api\v1\EmailController@rejectClient',
			'as' => 'api.v1.client.reject-client'
		]);

		/**
		 * Change status of the client
		 */
		Routes::post('/change-status/{id}', [
			'uses' => 'Api\v1\AdminClientController@setClientStatus',
			'as' => 'api.v1.client.change-status'
		]);
	});

});


/**
 * Client resource
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','client'],
    'role' => ['principal','teacher','parent','admin','super admin']
],function(){

    Routes::resource('/client','Api\v1\ClientController',
        ['except' => ['create','edit']]);

    Routes::get('client/custom/view-details/',[
		'uses' => 'Api\v1\ClientCustomController@getClient',
		'as' => 'api.v1.client.custom.view-details'
	]);
});
