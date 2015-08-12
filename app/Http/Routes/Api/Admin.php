<?php 

Routes::group(['prefix' => '/admin'], function()
{


	Routes::post('/login',[
        'uses' => 'Api\v1\AdminLoginController@login',
        'as' => 'api.v1.admin.login',
		'middleware' => ['api_after_admin_login']
    ]);

    /**
     * Authenticated admin routes
     */
    Routes::group([
        'middleware' => ['api_user','api_after'],
        'permission' => ['admin'],
        'role' => ['admin','super admin']
    ],function(){

        Routes::post('change-password/{id}',[
            'uses' => 'Api\v1\AdminPasswordController@changePassword',
            'as' => 'api.v1.admin.password'
        ]);
    });



    
    Routes::post('/change-email/{id}','Api\v1\EmailController@adminChangeEmail');

	Routes::post('/forgot-password/{id}','Api\v1\AdminPasswordController@forgotPassword');


	Routes::post('/check-email/{id}','Api\v1\AdminEmailController@checkEmail');

});


/**
 * Admin resource
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin'],
    'role' => ['admin','super admin']
],function(){

    Routes::resource('/admin','Api\v1\AdminController',
        ['except' => ['create', 'edit']]);
});
