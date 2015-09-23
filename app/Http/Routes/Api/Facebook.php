<?php

/**
 * Facebook registration.
 */
Routes::post('/registration/facebook',[
	'uses' => 'Api\v1\FacebookLoginController@facebookRegistration',
	'as' => 'api.v1.registration.facebook'
]);


//TODO: Add Token for middleware.
/**
 * Facebook login
 */
Routes::post('/login/facebook',[
	'uses' => 'Api\v1\FacebookLoginController@facebookLogin',
	'as' => 'api.v1.login.facebook',
	'middleware' => 'api_after_student_login'
]);