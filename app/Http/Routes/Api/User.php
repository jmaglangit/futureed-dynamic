<?php

Routes::group(['prefix' => '/user'], function() {

//users
    Routes::get('/', 'Api\v1\UserController@index');
    Routes::post('/password/reset', 'Api\v1\UserPasswordController@passwordReset');
    Routes::post('/password/forgot', 'Api\v1\UserPasswordController@passwordForgot');
    Routes::post('/password/code', 'Api\v1\UserPasswordController@confirmResetCode');
    Routes::post('/email', 'Api\v1\EmailController@checkEmail');
    Routes::post('/username', 'Api\v1\UserController@checkUser');
    Routes::post('/email/code', 'Api\v1\UserController@confirmEmailCode');
    Routes::post('/reset/code', 'Api\v1\UserController@resendResetEmailCode');
    Routes::post('/confirmation/code', 'Api\v1\UserController@resendRegisterEmailCode');


//avatars
    Routes::post('/avatar', ['middleware' => 'jwt','uses' => 'Api\v1\AvatarController@selectAvatars']);
    Routes::post('/avatar/new', 'Api\v1\AvatarController@saveUserAvatar');


});