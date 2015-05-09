<?php

//test routes

//token routes to be remove after test
Routes::get('/code','Api\v1\TokenController@getCode');
Routes::get('/sendmail','Api\v1\TokenController@sendMail');
Routes::post('/input','Api\v1\TokenController@input');