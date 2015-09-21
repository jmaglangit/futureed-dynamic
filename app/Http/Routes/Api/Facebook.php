<?php

/**
 * Facebook registration.
 */
Routes::post('/registration/facebook',[
	'uses' => 'Api\v1\FacebookLoginController@facebookRegistration',
	'as' => 'api.v1.registration.facebook'
]);
