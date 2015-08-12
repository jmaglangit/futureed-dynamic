<?php

Routes::group(['prefix' => '/school'], function()
{


    /**
     * Authenticated school routes
     */
    Routes::group([
        'middleware' => ['api_user','api_after'],
        'permission' => ['admin','client','student'],
        'role' => ['principal','teacher','parent','admin','super admin']
    ],function(){

        /**
         * School search
         */
        Routes::Post('/search',[
            'uses' => 'Api\v1\SchoolSearchController@schoolSearch',
            'as' => 'api.v1.school.search'
        ]);

    });
	//search school
	Routes::get('/search','Api\v1\SchoolSearchController@schoolSearch');

});

//schools
Routes::resource('/school','Api\v1\SchoolController',
    ['except' => ['create','edit']]);
