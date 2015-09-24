<?php

/**
 * Google registration.
 */
Routes::post('/registration/google',[
	'uses' => 'Api\v1\GoogleLoginController@googleRegistration',
	'as' => 'api.v1.registration.google'
]);

/**
 * Google login
 */
Routes::post('/login/google',[
	'uses' => 'Api\v1\GoogleLoginController@googleLogin',
	'as' => 'api.v1.login.google',
	'middleware' => 'api_after_auto_login'
]);