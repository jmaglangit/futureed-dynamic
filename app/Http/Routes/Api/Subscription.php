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
		'uses' => 'Api\v1\PaymentSubscriptionController@renewSubscription',
		'as' => 'subscription.renew']);

    Routes::post('/save-subscription', [
        'uses' => 'Api\v1\PaymentSubscriptionController@saveSubscription',
        'as' => 'subscription.save']);

    Routes::post('/pay-subscription', [
        'uses' => 'Api\v1\PaymentSubscriptionController@paySubscription',
        'as' => 'subscription.pay']);

    Routes::get('/subscription-package/countries',[
        'uses' => 'Api\v1\SubscriptionPackageController@getSubscriptionCountries',
        'as' => 'subscription-package.countries'
    ]);
});


//Subscription Package
Routes::resource('/subscription-package','Api\v1\SubscriptionPackageController',
    ['except' => ['create','edit']]);

//Subscription Days
Routes::resource('/subscription-day','Api\v1\SubscriptionDayController',
    ['except' => ['create','edit']]);