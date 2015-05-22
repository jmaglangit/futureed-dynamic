<?php

/**
 * Subject area resource
 */
Routes::group([
    'middleware' => ['api_user','api_after'],
    'permission' => ['admin','client','student'],
    'role' => ['principal','teacher','parent','admin','super_admin']
],function(){

    Routes::resource('/subject-area','Api\v1\SubjectAreaController',
        ['except' => ['create','edit']]);

});
