<?php

/**
 * Google registration.
 */
Routes::post('/registration/google',[
	'uses' => 'Api\v1\GoogleLoginController@googleRegistration',
	'as' => 'api.v1.registration.google'
]);