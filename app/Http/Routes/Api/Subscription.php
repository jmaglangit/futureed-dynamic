<?php

/**
 * Subscription resource
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','client','student'],
    'role' => ['principal','teacher','parent','admin','super admin']
],function(){

    Routes::patch('/update-status/{id}', [
        'uses' => 'Api\v1\SubscriptionController@update',
        'as' => 'subscription.update.status']);

    Routes::resource('/subscription','Api\v1\SubscriptionController',
        ['except' => ['create','edit']]);


	Routes::post('/renew-subscription/{id}', [
		'uses' => 'Api\v1\RenewSubscriptionController@renewSubscription',
		'as' => 'subscription.renew']);


});


//Subscription Package
//TODO transfer under permission
Routes::group([
    'prefix' => '/subscription-package'
],function(){

    Routes::get('/',[
        'uses' => 'Api\v1\SubscriptionPackageController@index',
        'as' => 'api.v1.subscription-package.index'
    ]);

    Routes::get('/{id}',[
        'uses' => 'Api\v1\SubscriptionPackageController@show',
        'as' => 'api.v1.subscription-package.show'
    ]);

});
