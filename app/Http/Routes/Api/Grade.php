<?php

//grade


Routes::resource('/grade','Api\v1\GradeController',
    ['except' => ['create','edit']]);

Routes::group(['middleware' => 'api_user','prefix' => '/grade'], function()
{

    Routes::put('/update/{id}',[
            'uses' => 'Api\v1\GradeCustomController@update',
            'as' =>'api.v1.grade.update' ]);
});



