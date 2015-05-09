<?php

//users
Routes::get('/user','Api\v1\UserController@index');
Routes::post('/user/password/reset','Api\v1\UserPasswordController@passwordReset');
Routes::post('/user/password/forgot','Api\v1\UserPasswordController@passwordForgot');
Routes::post('/user/password/code', 'Api\v1\UserPasswordController@confirmResetCode');
Routes::post('/user/email','Api\v1\EmailController@checkEmail');
Routes::post('/user/username','Api\v1\UserController@checkUser');
Routes::post('/user/email/code','Api\v1\UserController@confirmEmailCode');
Routes::post('/user/reset/code', 'Api\v1\UserController@resendResetEmailCode');
Routes::post('/user/confirmation/code', 'Api\v1\UserController@resendRegisterEmailCode');


//avatars
Routes::post('/user/avatar','Api\v1\AvatarController@selectAvatars');
Routes::post('/user/avatar/new','Api\v1\AvatarController@saveUserAvatar');