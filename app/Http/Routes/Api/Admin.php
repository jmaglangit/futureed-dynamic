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
            'as' => 'api.v1.admin.change-password'
        ]);

		Routes::post('/change-email/{id}',[
			'uses' => 'Api\v1\EmailController@adminChangeEmail',
			'as' => 'api.v1.admin.change-email'
		]);

		Routes::post('/check-email/{id}',[
			'uses' => 'Api\v1\AdminEmailController@checkEmail',
			'as' => 'api.v1.admin.check-email'
		]);

	});

	Routes::post('/forgot-password/{id}','Api\v1\AdminPasswordController@forgotPassword');
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
