<?php 

Routes::group(['prefix' => '/admin'], function()
{

	Routes::post('/login',[
        'uses' => 'Api\v1\AdminLoginController@login',
        'as' => 'api.v1.admin.login'
    ]);

    /**
     * Authenticated admin routes
     */
    Routes::group([
        'middleware' => ['api_user','api_after'],
        'permission' => ['admin'],
        'role' => ['admin','super_admin']
    ],function(){

        Routes::post('/password/{id}',[
            'uses' => 'Api\v1\AdminPasswordController@changePassword',
            'as' => 'api.v1.admin.password'
        ]);
    });



});


/**
 * Admin resource
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin'],
    'role' => ['admin','super_admin']
],function(){

    Routes::resource('/admin','Api\v1\AdminController',
        ['except' => ['create', 'edit']]);
});
