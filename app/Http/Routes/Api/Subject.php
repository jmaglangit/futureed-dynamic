<?php

/**
 * Subject resource
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','client','student'],
    'role' => ['principal','teacher','parent','admin','super admin']
],function(){

    Routes::resource('/subject','Api\v1\SubjectController',
        ['except' => ['create','edit']]);
});

