<?php

/**
 * Subscription resource
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','client','student'],
    'role' => ['principal','teacher','parent','admin','super_admin']
],function(){

    Routes::resource('/subscription','Api\v1\SubscriptionController',
        ['except' => ['create','edit']]);
});
