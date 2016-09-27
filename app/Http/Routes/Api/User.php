<?php

Routes::group(['prefix' => '/user'], function() {


    Routes::post('/password/reset', [
        'uses' => 'Api\v1\UserPasswordController@passwordReset',
        'as' => 'api.v1.user.password.reset',
    ]);

    Routes::post('/password/forgot', [
        'uses' => 'Api\v1\UserPasswordController@passwordForgot',
        'as' => 'api.v1.user.password.forgot'
    ]);

    Routes::post('/password/code', [
        'uses' => 'Api\v1\UserPasswordController@confirmResetCode',
        'as' => 'api.v1.user.password.code',
    ]);

    Routes::post('/email', [
        'uses' => 'Api\v1\EmailController@checkEmail',
        'as' => 'api.v1.user.email'
    ]);

    Routes::post('/username', [
        'uses' => 'Api\v1\UserController@checkUser',
        'as' => 'api.v1.user.username'
    ]);

    Routes::post('/email/code', [
        'uses' => 'Api\v1\UserController@confirmEmailCode',
        'as' => 'api.v1.user.email.code',
        'middleware' => 'api_after_auto_login'
    ]);

    Routes::post('/reset/code', [
        'uses' => 'Api\v1\UserController@resendResetEmailCode',
        'as' => 'api.v1.user.reset.code'
    ]);

    Routes::post('/confirmation/code', [
        'uses' => 'Api\v1\UserController@resendRegisterEmailCode',
        'as' => 'api.v1.user.confirmation.code'
    ]);


    //authenticated student access
    Routes::group(['middleware' => ['api_user','api_after']],function(){

        //avatars
        Routes::post('/avatar', [
            'uses' => 'Api\v1\AvatarController@selectAvatars',
            'as' => 'api.v1.user.avatar',
            'permission' => ['admin','client','student'],
            'role' => ['principal','teacher','parent','admin','super admin']
        ]);


        Routes::post('/avatar/new', [
            'uses' => 'Api\v1\AvatarController@saveUserAvatar',
            'as' => 'api.v1.user.avatar',
            'permission' => ['admin','client','student'],
            'role' => ['principal','teacher','parent','admin','super admin']
        ]);

    });


});

Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','client','student'],
    'role' => ['principal','teacher','parent','admin','super admin']
],function(){

    Routes::resource('/user','Api\v1\UserController',
        ['except' => ['create','edit']]);

    Routes::get('/user/curriculum-country/{user_id}',[
        'uses' => 'Api\v1\AvatarController@checkCurriculumCountry',
        'as' => 'api.v1.user.curriculum-country'
    ]);
});


/**
 * User Logout
 */
Routes::post('user/logout',[
    'uses' => 'Api\v1\UserController@logout',
    'as' => 'api.v1.user.logout',
    'middleware' => ['api_user'],
    'permission' => ['admin','client','student'],
    'role' => ['principal','teacher','parent','admin','super admin']
]);
