<?php

/**
 * Client discount resource.
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','client','student'],
    'role' => ['principal','teacher','parent','admin','super admin']
],function(){

    Routes::resource('/client-discount','Api\v1\ClientDiscountController',
        ['except' => ['edit']]);
});
