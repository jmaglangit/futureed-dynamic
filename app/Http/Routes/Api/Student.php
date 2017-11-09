<?php

Routes::group(['prefix' => '/student'], function()
{
	/**
	 * Authenticated student routes
	 */
	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['admin', 'client', 'student'],
		'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
	], function () {

		/**
		 * Student password
		 */
		Routes::post('/password/confirm/{id}', [
			'uses' => 'Api\v1\StudentPasswordController@confirmPassword',
			'as' => 'api.v1.student.password.confirm'
		]);

		/**
		 * Student email
		 */
		Routes::put('/email/{id}', [
			'uses' => 'Api\v1\EmailController@updateStudentEmail',
			'as' => 'api.v1.student.email'
		]);

		Routes::post('/confirmation/email', [
			'uses' => 'Api\v1\EmailController@confirmChangeEmail',
			'as' => 'api.v1.student.confirmation.email'
		]);
	});

	/**
	 * Student new password.
	 */
	Routes::post('/password/new', [
		'uses' => 'Api\v1\StudentPasswordController@confirmNewImagePassword',
		'as' => 'api.v1.student.password.new'
	]);

	/**
	 * Student password image
	 */
	Routes::get('/password/image', [
		'uses' => 'Api\v1\StudentPasswordController@getPasswordImages',
		'as' => 'api.v1.student.password.image'
	]);

	Routes::post('/password/reset', [
		'uses' => 'Api\v1\StudentPasswordController@passwordReset',
		'as' => 'api.v1.student.password.reset'
	]);

	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['student'],
	], function () {



		Routes::post('/password/code', [
			'uses' => 'Api\v1\StudentPasswordController@confirmResetCode',
			'as' => 'api.v1.student.password.code'
		]);

		Routes::post('/password/{id}', [
			'uses' => 'Api\v1\StudentPasswordController@changeImagePassword',
			'as' => 'api.v1.student.password'
		]);
	});

    // NOTE: Token to be inserted on success login.
	Routes::group([
		'middleware' => ['api_after_student_login'],
	], function () {

		/**
		 * Returns token if login confirm.
		 */
		Routes::post('/login/password', [
			'uses' => 'Api\v1\StudentLoginController@loginPassword',
			'as' => 'api.v1.student.login.password',
			'middleware' => 'api_after',
		]);


	});

	/**
	 * Student login
	 */
	Routes::post('/login/username', [
		'uses' => 'Api\v1\StudentLoginController@login',
		'as' => 'api.v1.student.login.username'
	]);


	Routes::post('/login/image', [
		'uses' => 'Api\v1\StudentLoginController@imagePassword',
		'as' => 'api.v1.student.login.image'
	]);

	Routes::post('/register', [
		'uses' => 'Api\v1\StudentRegistrationController@register',
		'as' => 'api.v1.student.register'
	]);


	Routes::group([
		'middleware' => ['api_user', 'api_after'],
		'permission' => ['student'],
		'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
	], function () {

		/**
		 * Student registration by invite
		 */
		Routes::post('/invite', [
			'uses' => 'Api\v1\StudentRegistrationController@invite',
			'as' => 'api.v1.student.invite'
		]);

		/**
		 * Student email resend
		 */
		Routes::post('/resend/email/{id}', [
			'uses' => 'Api\v1\EmailController@resendChangeEmail',
			'as' => 'api.v1.student.resend.email'
		]);
	});

});


/**
 * authenticated user resource
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','user','student'],
    'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::resource('/student', 'Api\v1\StudentController',
		['only' => ['index', 'show', 'update']]);

	Routes::resource('/student/background-image','Api\v1\StudentBackgroundImageController',
		['only' => ['show','update']]);

	Routes::get('/student/check-billing-address/{id}',
	[
		'as' => 'student.check-billing-address',
		'uses' => 'Api\v1\StudentController@checkBillingAddress'
	]);

	Routes::post('/student/billing-address/{id}',[
		'as' => 'student.update.billing-address',
		'uses' => 'Api\v1\StudentController@updateBillingAddress'
	]);

	Routes::get('/student/latest-details/{id}',
	[
		'as' => 'student.get.latest-details',
		'uses' => 'Api\v1\StudentController@getUpdatedDetails'
	]);

	Routes::get('/student/learning-style/{id}',[
		'as' => 'student.learning-style.id',
		'uses' => 'Api\v1\StudentController@checkRequiredLearningStyle'
	]);

	Routes::resource('/admin/manage/student', 'Api\v1\AdminStudentController',
		['except' => ['create', 'edit']]);

	Routes::get('/student/curriculum/export', [
		'uses' => 'Api\v1\StudentCurriculumController@downloadCurriculumPdf',
		'as' => 'api.v1.student.curriculum.export'
	]);

	Routes::get('/student/curriculum/export/link', [
		'uses' => 'Api\v1\StudentCurriculumController@getCurriculumPDFDownloadLink',
		'as' => 'api.v1.student.curriculum.export.link'
	]);

});

/**
 * Import batch of new students
 */
Routes::group([
		'middleware' => ['api_user','api_after'],
		'permission' => ['admin'],
		'role' => ['admin','super admin']
], function(){

	Routes::post('/student/import/link',[
		'uses' => 'Api\v1\StudentImportController@studentImport',
		'as' => 'api.v1.student.import.csv'
	]);
});